<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'surname' => 'required',
            'gender' => 'required',
            'password' => 'required|string|min:8',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'date_of_birth' => 'required|date',
            'province' => 'required',
        ];
    }

    public function messages()
    {
        return 
        [
            'surname.required' => 'Họ không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'name.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'date_of_birth.required' => 'Ngày sinh không được để trống',
            'date_of_birth.date' => 'Ngày sinh không hợp lệ',
            'province.required' => 'Tỉnh không được để trống',
        ];
    }
}
