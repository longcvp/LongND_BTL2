<?php

namespace App\Http\Requests;

use Hash;
use App\Models\Wallet;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
        $id = $req->from_wallet;
        $data = Wallet::find($id);
        $code = $req->code;
        $codeCheck = $data->code;
        $money = $data->money;
        return [
            'code' => ['required',function ($attribute, $code, $fail) use ($codeCheck) {
                                        if (! Hash::check($code, $codeCheck)) {
                                            $fail('Mã bí mật không đúng');
                                        }
                                    }],
            'parent_id' => 'required',
            'type' => 'required',
            'money' => 'required|numeric|min:0|max:' . $money,
        ];
    }

    public function messages()
    {
        return [
            'name.required '=> 'Tên ví không được để trống',
            'name.unique' => 'Tên ví đã tồn tại',
            'code.required' => 'Mã bí mật không được để trống',
            'parent_id.required' => 'Danh mục giao dịch không được để trống',
            'ssid.digits' => 'Mã bí mật là số có 12 kí tự',
            'money.required' => 'Số tiền không được để trống',
            'money.numeric' => 'Số tiền phải là số',
            'money.min' => 'Số tiền chuyển đi phải lớn hơn hoặc bằng 0',
            'money.max' => 'Số tiền chuyển đi phải nhỏ hơn số tiền còn lại trong ví',
            'code.min' => 'Mã bí mật phải tối thiểu 4 số',
        ];   
    }
}
