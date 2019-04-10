<?php

namespace App\Rules;

use Auth;
use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

class CheckNameRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($userId, $cateId = 0)
    {
        $this->userId = $userId;
        $this->cateId = $cateId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $query = Category::where('user_id', $this->userId);
        if ($this->cateId != 0 ) {
            $query = $query->where('id', '<>', $this->cateId);
        }
        $categories = $query->get();
        $arrayName = array();
        if (count($categories) == 0) {
            return true;
        } else {
           foreach ($categories as $category) {
                $arrayName[] = $category->name;
            }

            return !in_array($value,$arrayName);        
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Tên danh mục đã tồn tại';
    }
}
