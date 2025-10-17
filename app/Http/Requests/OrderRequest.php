<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization granular control done in controller (roles)
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'client_name' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:500'],
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed'])],
            'delivery_date' => ['required', 'date', 'after_or_equal:today'],
        ];

        // For PUT (update), we don't validate uniqueness here because it's cross-field unique
        return $rules;
    }
}
