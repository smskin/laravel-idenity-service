<?php

namespace SMSkin\IdentityService\Http\Api\Requests\Auth\Phone;

use SMSkin\IdentityService\Modules\Auth\Support\Helpers;
use SMSkin\LaravelSupport\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class SubmitPhoneVerificationCodeRequest extends FormRequest
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
            ]
        ];
    }

    protected function prepareForValidation()
    {
        /** @noinspection PhpUndefinedFieldInspection */
        $this->merge([
            'phone' => Helpers::clearPhone($this->phone)
        ]);
    }
}
