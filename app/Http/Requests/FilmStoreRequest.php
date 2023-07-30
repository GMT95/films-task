<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmStoreRequest extends FormRequest
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
            'name' => 'required|max:100',
            'description' => 'required|max:250',
            'release_date' => 'required|date',
            'rating' => 'required|numeric|gte:1|lte:5|decimal:0,1',
            'ticket_price' => 'required|numeric|decimal:0,2',
            'country' => 'required',
            'photo' => 'required|image|max:2048',
            'genres' => 'required|array',
            'genres.*' => 'min:1|exists:genres,id'
        ];
    }
}
