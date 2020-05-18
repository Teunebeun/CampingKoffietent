<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' =>               ['required', 'string', 'max:45'],
            'middlename' =>         ['string', 'nullable', 'max:45'],
            'lastname' =>           ['required', 'string', 'max:45'],
            'phonenumber' =>        ['nullable', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10'],
            'profile_picture' =>    ['image', 'max:2048'],
            'email' => [
                'required',
                'max:60',
                'email',
                function($attribute, $value, $fail) {
                    foreach(User::all() as $user) {
                        $value === $user->email && $fail("E-mail adres moet uniek zijn");
                    }
                }
            ],
        ];
    }
}
