<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Clients;

class ClientsRequest extends FormRequest
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

        $rules = Clients::$rules;

        if (is_numeric($lastUrl)) {
            $rules['name'] = 'required|unique:clients,name,'.$lastUrl;
            $rules['email'] = 'required|unique:clients,email,'.$lastUrl;
        }else{
            $rules['name'] = 'required|unique:clients,name';
            $rules['email'] = 'required|unique:clients,email';
        }

        return $rules;
    }
}
