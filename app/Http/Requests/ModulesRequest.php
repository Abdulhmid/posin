<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Modules;

class ModulesRequest extends FormRequest
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
        $rules = Modules::$rules;
        $last    = \GLobalHelper::lastUrl();  

        if(is_numeric($last)) : 
            $rules['module_name'] ='required|unique:modules,module_name,'.$last.',module_id';
            $rules['module_name_alias'] ='required|unique:modules,module_name_alias,'.$last.',module_id';
        else :
            $rules['module_name'] ='required|unique:modules,module_name';
            $rules['module_name_alias'] ='required|unique:modules,module_name_alias';
        endif;

        return $rules;
    }
}
