<?php
namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;
class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request) {
        if (isset($request->token)) {
            $tokenBD = DB::table('password_reset_tokens')->select('token','created_at')->where('email', $request->email)->first();
            $fechaActual = Carbon::now();
            $fechaExpiracion = Carbon::parse($tokenBD->created_at);
            $vigente = $fechaExpiracion->diffInHours($fechaActual) <= 24 ? 1 : 0;
            $valido = Hash::check($request->token, $tokenBD->token) ? 1 :0;
            return view('auth.password-reset', ['token' => $request->token,'email' => $request->email,'valido' => $valido,'vigente' => $vigente]);
        } else {
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                return $this->errorResponse('El email no existe', 404);
            }
            $status = Password::sendResetLink($request->only('email'));
            if ($status === Password::RESET_LINK_SENT) {
                return $this->successResponse('Se ha enviado un email para restablecer la contraseña', 200);
            } else {
                return $this->errorResponse('Error al enviar el email', 500);
            }
        }
        $user = User::where('email', $request->input('email'))->first();
        if (!$user) {
            return $this->errorResponse('El email no existe', 404);
        }
        $status = Password::sendResetLink($request->only('email'));
        if ($status === Password::RESET_LINK_SENT) {
            return $this->successResponse('Se ha enviado un email para restablecer la contraseña', 200);
        } else {
            return $this->errorResponse('Error al enviar el email', 500);
        }
    }

    public function successResponse($message, $status) {
        return response()->json([
            'message' => $message,
            'status' => $status,
        ], $status);
    }    
    public function errorResponse($message, $status) {
        return response()->json([
            'message' => $message,
            'status' => $status,
        ], $status);
    }
    public function password_update(Request $request) {
        $password= '"';
        $fields = $request->validate([
         'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.\-_,()=#|[\]{])[A-Za-z\d@$!%*?&.\-_,()=#|[\]{]+$/',
            ],
        ], [
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener una letra mayúscula, una letra minúscula, un número y un carácter especial.',
        ]);
        User::where('email', $request->email)->update(['password' => bcrypt($fields['password'])]);
        $response = [
            'message' => 'La clave ha sido actualizada exitosamente'
        ];
        Session::flash('success_message', 'La clave ha sido actualizada exitosamente');
        return view('auth.password-message');
    }
    public function massAssignPasswords() {
        ini_set('max_execution_time', 6000);
        User::query()->update(['password' => Hash::make('ReniiOnctiv2.')]);
        return response()->json(['message' => 'Contraseñas actualizadas masivamente con éxito'], 200);
    }


}
