<?php

namespace SMSkin\IdentityService\Http\Api\Requests\Auth\Phone;

use SMSkin\IdentityService\Modules\Auth\Support\Helpers;
use SMSkin\LaravelSupport\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorizeByPhoneRequest extends FormRequest
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
            'phone' => [
                'required',
                new PhoneRule()
            ],
            'code' => [
                'required'
            ],
            'scopes' => [
                'required',
                'array'
            ],
            'scopes.*' => [
                'required',
                Rule::exists('scopes', 'slug')
            ]
        ];
    }

    protected function prepareForValidation()
    {
        /** @noinspection PhpUndefinedFieldInspection */
        $this->merge([
            'phone' => Helpers::clearPhone($this->phone),
            'scopes' => array_map('trim', explode(',', $this->scopes))
        ]);
    }
}
