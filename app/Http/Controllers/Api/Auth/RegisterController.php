<?php
namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class RegisterController extends Controller
{
    public function prueba1() {
        return response()->json([
            'message' => 'Prueba 1'
        ], 201);
    }
    public function prueba2() {
        return response()->json([
            'message' => 'Prueba 2'
        ], 201);
    }
    public function massUpdatePasswords() {
        set_time_limit(900);
        $users = User::all();

        foreach ($users as $user) {
            $user->password = Hash::make('ReniiOnctiv2.');
            $user->save();
        }

        return response()->json([
            'message' => 'La actualización masiva de contraseñas se ha realizado con éxito'
        ], 200);
    }
    
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.\-_,()=#|[\]{])[A-Za-z\d@$!%*?&.\-_,()=#|[\]{]+$/',
            ],
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'Ingrese un correo electrónico válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener una letra mayúscula, una letra minúscula, un número y un carácter especial.',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'email_verified_at' => null,
        ]);

        event(new Registered($user));

        return response()->json([
            'message' => 'El registro del usuario ha sido exitoso'
        ], 201);
    }
    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'El correo electrónico ya ha sido verificado previamente'
            ], 400);
        }
        $user->markEmailAsVerified();
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        return response()->json([
            'message' => 'El correo electrónico ha sido verificado exitosamente'
        ], 200);
    }
    public function resendVerify(Request $request) {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'No se encontró un usuario con ese correo electrónico'
            ], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'El correo electrónico ya ha sido verificado previamente'
            ], 400);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'El correo de verificación ha sido reenviado exitosamente'
        ], 200);
    }

}
