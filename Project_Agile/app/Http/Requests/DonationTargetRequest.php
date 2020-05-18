<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonationTargetRequest extends FormRequest
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
//        dd($this->donation_needed);
//        $this->donation_needed = number_format(floatval($this->donation_needed), 2, '.', '');
//        dd($this->donation_needed);
        return [
            'title' => 'required|string|max:45',
            'donation_item' => 'required|string|max:45',
            'donation_needed' => 'required|numeric|between:0,99999999.99',
            'description' => 'required|max:255|string'
        ];
    }

    public function messages()
    {
        return [
            'title.required'            => 'Vul alstjeblieft een titel in!',
            'title.string'              => 'De titel is van een ongeldig type!',
            'title.max'                 => 'De titel mag maximaal 45 karakters bevatten!',
            'donation_item.required'    => 'Vul alstjeblieft een donatie voorwerp in!',
            'donation_item.string'      => 'Het donatie voorwerp is van een ongeldig type!',
            'donation_item.max'         => 'Het donatie voorwerp veld mag maximaal 45 karakters bevatten!',
            'donation_needed.required'  => 'Vul alstjeblieft in hoeveel voorwerpen je wilt aanvragen!',
            'donation_needed.numeric'   => 'De donatie hoeveelheid moet numeriek zijn!',
            'donation_needed.between'   => 'De donatie hoeveelheid mag niet meer dan 8 cijfers en 2 decimalen bevatten!',
            'description.required'      => 'Vul alstjeblieft een beschrijving in!',
            'description.max'           => 'De beschrijving mag maximaal 255 karakters bevatten!',
            'description.string'        => 'De beschrijving is van een ongeldig type!',
        ];
    }
}
