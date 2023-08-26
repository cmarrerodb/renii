<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    // public function resetPassword(ResetPasswordRequest $request) {
    //     $user = User::where('email', $request->email)->first();
    //     if (!$user) {
    //         return $this->errorResponse('El email no existe', 404);
    //     }
    //     $status = Password::sendResetLink($request->only('email'));
    //     if ($status === Password::RESET_LINK_SENT) {
    //         return $this->successResponse('Se ha enviado un email para restablecer la contraseña', 200);
    //     } else {
    //         return $this->errorResponse('Error al enviar el email', 500);
    //     }
    // }

    public function resetPassword(Request $request) {
        if (isset($request->token)) {
            return view('auth.password-reset', ['token' => $request->token,'email' => $request->email]);
            // return response()->json([
            //     'token' => $request->token,
            //     'email' => $request->email,
            // ], 200);
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
    // public function resetPassword(ResetPasswordRequest $request) {
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

/*     public function resetPassword($email) {
        // dd($request->all());
    // public function resetPassword(ResetPasswordRequest $request) {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return $this->errorResponse('El email no existe', 404);
        }
        $status = Password::sendResetLink($email);
        if ($status === Password::RESET_LINK_SENT) {
            return $this->successResponse('Se ha enviado un email para restablecer la contraseña', 200);
        } else {
            return $this->errorResponse('Error al enviar el email', 500);
        }
    } */
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
    // public function resetPasswordForm(Request $request, $token)
    // {
    //     return view('auth.password-reset', ['token' => $token]);
    // }

    public function password_update(Request $request) {
        dd("pepe");
    }

}
