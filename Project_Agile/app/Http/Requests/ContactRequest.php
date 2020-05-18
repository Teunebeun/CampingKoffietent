<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        return [
            'name' => 'required|max:250',
            'email' => 'required|email|max:250',
            'message' => 'required|max:800|min:10'
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Vul alstjeblieft je naam in!',
            'name.max'          => 'Je naam mag maximaal 250 karakters bevatten!',
            'email.required'    => 'Vul alstjeblief je emailadres in!',
            'email.email'       => 'Dit is een ongeldig emailadres!',
            'email.max'         => 'Je emailadres mag maximaal 250 karakters bevatten!',
            'message.required'  => 'Je bericht mag niet leeg zijn!',
            'message.max'       => 'Je bericht mag maximaal 800 karakters bevatten!',
            'message.min'       => 'Je bericht moet minimaal 10 karakters bevatten!',
        ];
    }
}
