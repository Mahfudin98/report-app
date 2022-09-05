<?php

namespace App\Http\Requests\administrator;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category_id'   => 'required',
            'product_bpom'  => 'nullable',
            'product_name'  => 'required',
            'image'         => 'nullable|image|mimes:png,jpeg,jpg|max:500000',
            'product_stock' => 'nullable|integer',

            'end_user'      => 'nullable|integer',
            'reseller'      => 'nullable|integer',
            'agen'          => 'nullable|integer',
        ];
    }
}
