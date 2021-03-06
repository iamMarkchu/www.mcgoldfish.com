<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'integer',
            'tag_ids' => 'array',
            'title' => 'required|max:255|min:3|unique:articles',
            'image' => 'max:255',
            'display_order' => 'integer',
            'source' => [
                'required',
                Rule::in('origin', 'reprint')
            ]
        ];
    }
}
