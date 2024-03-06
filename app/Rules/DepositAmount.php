<?php

namespace App\Rules;

use App\Models\DepositRecord;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class DepositAmount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $actualAmount = DepositRecord::where('user_id', Auth::user()->id)
            ->first();
        if(!empty($actualAmount)){
            return $value <= $actualAmount->current_amount;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute is greater then your deposit amount.';
    }
}
