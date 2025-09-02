<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class RegisterFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            'email' => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|confirmed|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute は必須です。',
            'email' => ':attribute の形式が不正です。',
            'unique' => 'その :attribute は既に使用されています。',
            'confirmed' => ':attribute が確認用と一致しません。',
            'max' => ':attribute は :max 文字以内で入力してください。',
            'min' => ':attribute は最低 :min文字必要です。'
        ];
    }
}
