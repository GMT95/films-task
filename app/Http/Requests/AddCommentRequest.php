<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCommentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "text" => ["required", "min:5", "max:100"]
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'text' => strip_tags($this->text),
        ]);
    }
}
