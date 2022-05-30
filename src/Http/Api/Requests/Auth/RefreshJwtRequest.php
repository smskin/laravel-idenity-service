<?php

namespace SMSkin\IdentityService\Http\Api\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RefreshJwtRequest extends FormRequest
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
            'token' => [
                'required'
            ],
            'scopes' => [
                'nullable',
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
        $scopes = $this->scopes;
        if ($scopes) {
            $this->merge([
                'scopes' => array_map('trim', explode(',', $scopes))
            ]);
        }
    }
}
