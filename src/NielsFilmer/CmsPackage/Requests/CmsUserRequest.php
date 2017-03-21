<?php

namespace VodafoneStutter\Http\Requests\Cms;

use Illuminate\Foundation\Http\FormRequest;

class CmsUserRequest extends FormRequest
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
        switch($this->method())
        {
            case 'PUT':
            case 'PATCH':
                $emailrule = "max:255|email|unique:users,email,{$this->user}";
                $passwordrule = 'confirmed|min:8|not_in:password,12345678,qwertyui';
                break;
            case 'POST':
            default:
                $emailrule = 'max:255|email|unique:users,email';
                $passwordrule = 'required|confirmed|min:8|not_in:password,12345678,qwertyui';
                break;
        }

        return [
            'name' => 'required|max:255',
            'email' => $emailrule,
            'password' => $passwordrule,
        ];
    }
}
