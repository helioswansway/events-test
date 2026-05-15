<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Bitfumes\Multiauth\Model\Exec;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ExecPasswordExpiredRequest  extends FormRequest
{
    //

    public function authorize()
    {
        return true;
    }

}
