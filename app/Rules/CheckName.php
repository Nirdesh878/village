<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckName implements Rule
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
        // DB::enableQueryLog();
        $res = DB::table('partners')
                ->where('partners_name', $value)
                ->where('is_deleted', 0)
                ->get();
        $query = DB::getQueryLog();
        // prd($query);
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
        return 'Partner Name is already exist';
    }
}
