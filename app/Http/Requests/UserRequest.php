<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        return [
            'name' => 'required|max:255',
            'phone' => 'required|digits_between:9,13|
                        unique:infomations,phone,' . $id . ',user_id',
            'avatar' => 'image',
            'address' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống!',
            'name.max' => 'Tên tối đa 255 kí tự!',
            'avatar.image' => 'Ảnh phải có đuôi .jpg , .png',
            'phone.required'  => 'Số điện thoại không được để trống',
            'phone.digits_between'  => 'Số điện thoại có 9 đến 13 số',
            'phone.unique'  => 'Số điện thoại đã tồn tại',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'email.required' => 'Email không được để trống',
            'address.required' => 'Địa chỉ không được để trống',
            'gender.required' => 'Chọn giới tính của mình',
            'email.email' => 'Email có định dạng @abc.com',
        ];
    }
}
