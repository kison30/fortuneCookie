<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberProfileRequst extends FormRequest
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
        $inputs = $this->all();
        $input_keys = array_keys($inputs);
        foreach ($input_keys as  $key_name) {
            if($key_name=='_token'){
                continue;
            }
            $this->session()->flash($key_name, $inputs[$key_name]);
        }

        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'postcode'    => 'required',
            'city'        =>'required',
        ];
    }
}
