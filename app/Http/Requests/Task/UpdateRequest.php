<?php

namespace App\Http\Requests\Task;

use App\Rules\FutureDate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'due_date' => ['nullable', 'date', new FutureDate],
            'status' => ['in:failed,completed,pending'],
        ];
    }
}
