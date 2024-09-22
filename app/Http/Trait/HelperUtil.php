<?php

namespace App\Http\Trait;

use Illuminate\Support\Facades\Validator;

trait HelperUtil
{
    public function validateId($id, $table)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => "required|integer|exists:{$table},id"]
        );

        return $validator;
    }

}
