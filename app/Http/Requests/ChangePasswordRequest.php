<?php

namespace App\Http\Requests;

use Auth;
use Hash;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $request = request();
        $id = $request->id;
        $oldPassword = $request->old_password;
        return [
                'old_password' => function ($attribute, $oldPassword, $fail) {
                                    if (! Hash::check($oldPassword, Auth::user()->password)) {
                                        $fail('Mật khẩu cũ bạn không đúng');
                                    }
                                },
                'email'  => 'required|email|exists:users,email,id,' . $id,
                'password' => 'required|different:old_password|min:6',
                'confirm_password'  => 'required|same:password',
            ];           
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
            'confirm_password.required' => 'Vui lòng nhập lại mật khẩu',
            'confirm_password.same' => 'Mật khẩu nhập lại không giống mật khẩu đã nhập',
            'email.email' => 'Email phải có dạng @abc',
            'password.min' => 'Mật khẩu phải tối thiểu 6 kí tự',
            'email.exists' => 'Nhập đúng email của mình',
            'password.different' => 'Mật khẩu mới phải khác mật khẩu cũ',
        ];
    }
}
