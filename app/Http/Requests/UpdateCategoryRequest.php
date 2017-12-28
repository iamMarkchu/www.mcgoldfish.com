<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        $id = $this->route('category')->id;
        return [
            'category_name' => 'required|max:50|min:2|unique:categories,category_name,'. $id,
            'parent_id' => 'required|integer',
            'display_order' => 'required|integer'
        ];
    }
}
