<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPassRequest extends FormRequest
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
        return [
            'email' =>  'required|email|exists:users,email',
            're_email' =>  'required|email|same:email',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Địa chỉ email không được bỏ trống',
            'email.email' => 'Địa chỉ email phải có định dạng @abc.com',
            'email.exists' => 'Địa chỉ email không tồn tại trong hệ thống',
            're_email.required' => 'Địa chỉ email nhập lại không được bỏ trống',
            're_email.email' => 'Địa chỉ email nhập lại phải có định dạng @abc.com',
            're_email.same' => 'Địa chỉ email nhập lại phải giống email đã nhập',
        ];
    }
}
