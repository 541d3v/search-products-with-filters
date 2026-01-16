<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetProductsRequest extends FormRequest
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
            'q' => ['nullable', 'string', 'max:255'],
            'price_from' => ['nullable', 'numeric', 'min:0'],
            'price_to' => ['nullable', 'numeric', 'min:0'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'in_stock' => ['nullable', 'in:0,1,true,false'],
            'rating_from' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'sort' => ['nullable', 'string', 'in:price_asc,price_desc,rating_desc,newest'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'price_from.numeric' => 'The price_from must be a valid number.',
            'price_from.min' => 'The price_from must be at least 0.',
            'price_to.numeric' => 'The price_to must be a valid number.',
            'price_to.min' => 'The price_to must be at least 0.',
            'category_id.exists' => 'The selected category does not exist.',
            'in_stock.in' => 'The in_stock must be 0, 1, true, or false.',
            'rating_from.numeric' => 'The rating_from must be a valid number.',
            'rating_from.min' => 'The rating_from must be at least 0.',
            'rating_from.max' => 'The rating_from must be at most 5.',
            'sort.in' => 'The sort must be one of: price_asc, price_desc, rating_desc, newest.',
            'page.integer' => 'The page must be an integer.',
            'page.min' => 'The page must be at least 1.',
            'per_page.integer' => 'The per_page must be an integer.',
            'per_page.min' => 'The per_page must be at least 1.',
            'per_page.max' => 'The per_page must not exceed 100.',
        ];
    }

    /**
     * Get the validated data, providing defaults for pagination.
     */
    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated($key, $default);

        if ($key !== null) {
            return $validated;
        }

        return array_merge($validated, [
            'page' => $this->input('page', 1),
            'per_page' => $this->input('per_page', 15),
            'sort' => $this->input('sort', 'newest'),
        ]);
    }
}
