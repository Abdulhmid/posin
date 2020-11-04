<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Roles;

class RolesRequest extends FormRequest
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

        $rules = [];

        if (is_numeric($lastUrl)) {
            $rules['label'] = 'required|unique:roles,label,'.$lastUrl;
            $rules['name'] = 'required|unique:roles,name,'.$lastUrl;
        }else{
            $rules['label'] = 'required|unique:roles,label';
            $rules['name'] = 'required|unique:roles,name';
        }

        return $rules;
    }
}
