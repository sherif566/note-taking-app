<?php

namespace App\Http\Requests;

class CategorySearchRequest extends PaginationRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // Merge the pagination rules from the parent class with the specific rules for this request
        return array_merge(parent::rules(), [
            'name' => ['nullable', 'string', 'max:255'],
            'parent_id' => ['nullable', 'integer'],
        ]);
    }
}
