<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
            "title" => "required|unique:articles",
            "category" => "required",
            "content" => "required",
            "image" => "file|max:2000|mimes:jpg,jpeg,png"
        ];
    }

    public function messages() {
        return [
            "title.unique" => "Judul sudah ada, gunakan judul lain"
        ];
    }
}
