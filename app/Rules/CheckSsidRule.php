<?php

namespace App\Rules;

use Auth;
use App\Models\Wallet;
use Illuminate\Contracts\Validation\Rule;

class CheckSsidRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($userID, $cateId = 0)
    {
        $this->userID = $userID;
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
        $wallet = Wallet::where('ssid',$value)->where('user_id', '<>', $this->userID)->count();
        if ($wallet == 1) {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Tài khoản nhận không hợp lệ';
    }
}
