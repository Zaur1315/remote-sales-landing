<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\RemoteSalesApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreRemoteSalesApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'telegram_username' => [
                'required',
                'string',
                'max:100',
            ],
            'english_level' => [
                'required',
                'string',
                Rule::in(RemoteSalesApplication::englishLevels()),
            ],
            'sales_experience' => [
                'required',
                'string',
                'max:5000',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'telegram_username.required' => 'Telegram username is required.',
            'telegram_username.max' => 'Telegram username must not be longer than 100 characters.',

            'english_level.required' => 'English level is required.',
            'english_level.in' => 'Please select a valid English level.',

            'sales_experience.required' => 'Sales experience is required.',
            'sales_experience.max' => 'Sales experience must not be longer than 5000 characters.',
        ];
    }
}
