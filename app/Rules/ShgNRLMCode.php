<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ShgNRLMCode implements Rule
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

        $nrlm = implode(',',$value);
        $res = DB::table('shg_profile')
                ->where('shg_code', $value)
                ->where('is_deleted', 0)
                ->get();
        $total = $res->count();
        if($total)
            return false;
        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Shg is already exist';
    }
}
