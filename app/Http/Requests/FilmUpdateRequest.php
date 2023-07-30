<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmUpdateRequest extends FormRequest
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
            'name' => 'sometimes|max:100',
            'description' => 'sometimes|max:250',
            'release_date' => 'sometimes|date',
            'rating' => 'sometimes|numeric|gte:1|lte:5|decimal:0,1',
            'ticket_price' => 'sometimes|numeric|decimal:0,2',
            'country' => 'sometimes',
            'photo' => 'sometimes|image|max:2048',
            'genres' => 'sometimes|array',
            'genres.*' => 'min:1|exists:genres,id'
        ];
    }
}
