<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckNameRule;

class CategoryRequest extends FormRequest
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
        $cateId = is_null($req->id) ? 0 : $req->id;

        return [
            'name' => ['required', new CheckNameRule($userId, $cateId)],
            'type' => 'required',
            'parent_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên danh mục không được để trống',
            'name.max' => 'Tên danh mục tối đa 255 kí tự',
            'name.unique' => 'Tên danh mục đã tồn tại',
            'name.type' => 'Tên danh mục không được để trống',
            'name.parent_id' => 'Tên danh mục không được để trống'
        ];        
    }
}
