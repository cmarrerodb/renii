<?php

namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\VerifiesEmails;
use App\Models\User;
use App\Models\Accesos;
use App\Models\Ingresos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request) {
        $fields = $request->validate([
            'email' =>'required|string|email',
            'password' =>'required|string'
        ]);
        $user = User::where('email',$fields['email'])->first();
        if (!$user || !Hash::check($fields['password'],$user->password)) {
            $this->accesos($request,$user->id,2,null);
            return response([
                'message' => 'Credenciales erróneas'
            ],401);
        } 
        if (!$user->hasVerifiedEmail()) {
            $this->ingresos($request, $user->id, 3, null);
            return response([
                'message' => 'Debe verificar su correo electrónico antes de iniciar sesión'
            ], 401);
        }        
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
            'ip' => $request->ip()
        ];
        $this->ingresos($request,$user->id,1,$token);
        return response($response, 201);
    }
    public function logout(Request $request) {
        $user = $request->user();
        $token = $request->bearerToken();
        $ingreso = Ingresos::where('token', $token)->first();
        if ($ingreso) {
            $ingreso->fecha_salida = now();
            $ingreso->status_salida = 1;
            $ingreso->save();
        }
        // if ($acceso) {
            //     $acceso->fecha_salida = now();
            //     $acceso->status_salida = 1;
            //     $acceso->save();
            // }
            foreach ($user->tokens as $token) {
                $token->delete();
            }
            unset($user);
        return [
            'message' => 'Salió del sistema'
        ];
    }
    public function ingresos($request,$user,$status,$token) {
        if ($status === 1) {
            $ingreso = new Ingresos();
            $ingreso->usuario_id = $user;
            $ingreso->fecha_ingreso = now();
            $ingreso->token = $token;
            $ingreso->ip = $request->ip();
            $ingreso->status_ingreso = $status; // ingreso exitoso
            $ingreso->save();
        }

        return;
    }    
    public function mail_check($codigo) {
        $user = User::where('codigo', $codigo)->first();
        $fecha_vencimiento = Carbon::parse($user->created_at);
        $fecha_actual = Carbon::now();

    }
}
