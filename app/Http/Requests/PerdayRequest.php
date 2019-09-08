<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerdayRequest extends FormRequest
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
            'type' =>'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];
    }

    public function messages()
    {
        return [
            'start_date.required'=> 'Ngày bắt đầu là bắt buộc',
            'end_date.after' => 'Ngày kết thúc là sau ngày bắt đầu',
            'end_date.required' => 'Ngày kết thúc là trường bắt buộc',           
            'type.required' => 'Chọn loại lọc (theo ngày/theo tháng)',
        ];        
    }
}
