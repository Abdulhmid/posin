<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Users;

class UsersRequest extends FormRequest
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
        $lastUrl = \Request::segment(2);

        $rules = Users::$rules;

        if (is_numeric($lastUrl)) {
            $rules['name']      = 'required|unique:clients,name,'.$lastUrl;
            $rules['password']  = 'confirmed';
            $rules['email']     = 'required|unique:clients,email,'.$lastUrl;
        }else{
            $rules['name']      = 'required|unique:clients,name';
            $rules['password']  = 'required|confirmed';
            $rules['email']     = 'required|unique:clients,email';
        }

        return $rules;
    }
}
