<?php

namespace SMSkin\IdentityService\Http\Api\Requests\Auth\Email;

use Illuminate\Foundation\Http\FormRequest;

class ValidateEmailCredentialsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required'
            ]
        ];
    }
}
