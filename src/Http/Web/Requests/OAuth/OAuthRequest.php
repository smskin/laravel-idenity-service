<?php

namespace SMSkin\IdentityService\Http\Web\Requests\OAuth;

use Illuminate\Foundation\Http\FormRequest;

class OAuthRequest extends FormRequest
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
            'callback-url' => [
                'required',
                'url'
            ],
            'key' => [
                'required'
            ],
            'signature' => [
                'required'
            ]
        ];
    }
}
