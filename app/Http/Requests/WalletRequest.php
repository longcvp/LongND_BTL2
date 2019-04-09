<?php

namespace App\Http\Requests;

use Hash;
use App\Models\Wallet;
use Illuminate\Foundation\Http\FormRequest;

class WalletRequest extends FormRequest
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
        $req = request();
        $userId = $req->user_id;
        $code = $req->code;
        if ($req->getMethod() == 'POST') {
            return [
                'name' => 'required|unique:wallets,name,' . $userId . ',user_id|max:255',
                'code' => 'required|min:4',
                're_code' => 'required|same:code',
                'money' => 'required|numeric|min:0',          
            ];
        } else {
            $id = $req->id;
            $data = Wallet::find($id);
            $codeCheck = $data->code;
            return [
                'name' => 'required|unique:wallets,name,' . $id . ',id|max:255',  
                'code' => function ($attribute, $code, $fail) use ($codeCheck) {
                                    if (! Hash::check($code, $codeCheck)) {
                                        $fail('Mã bí mật không đúng');
                                    }
                                },      
            ];            
        }

    }

    public function messages()
    {
        return [
            'name.required' => 'Tên ví không được để trống',
            'name.unique' => 'Tên ví đã tồn tại',
            'code.required' => 'Mã bí mật không được để trống',
            'money.required' => 'Số tiền không được để trống',
            'money.numeric' => 'Số tiền phải là số',
            'money.min' => 'Số tiền phải lớn hơn hoặc bằng 0',
            're_code.required' => 'Vui lòng nhập lại Mã bí mật',
            're_code.same' => 'Mã bí mật nhập lại không giống Mã bí mật đã nhập',
            'code.min' => 'Mã bí mật phải tối thiểu 4 số',
            'code.numeric' => 'Mã bí mật phải là số',

        ];
    }
}
