<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password_confirmation.required' => 'La confirmación de la contraseña es obligatoria.',
            'password_confirmation.same' => 'La contraseña y la confirmación de la contraseña no coinciden.',
        ];
    }
}