<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request) {
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

    public function verify(Request $request) {
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

public function resetPassword(Request $request) {
    $request->validate([
        'email' => 'required|email',
        'token' => 'required|string',
        'password' => 'required|string|confirmed|min:8',
    ]);

    $response = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
        $user->forceFill([
            'password' => bcrypt($password)
        ])->save();
    });

    if ($response !== Password::PASSWORD_RESET) {
        return response()->json(['message' => trans($response)], 400);
    }

    return response()->json(['message' => 'Password reset successful'], 200);
}

    // public function sendResetLinkEmail(Request $request) {
    //     $request->validate(['email' => 'required|email']);
    //     $response = Password::sendResetLink($request->only('email'));
    //     return $response == Password::RESET_LINK_SENT
    //                 ? response()->json(['message' => 'Se ha enviado un enlace de restablecimiento de contraseña a su correo electrónico'], 200)
    //                 : response()->json(['message' => 'No se pudo enviar el enlace de restablecimiento de contraseña'], 400);
    // }    
}
