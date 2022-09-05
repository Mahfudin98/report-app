<?php

namespace App\Http\Requests\administrator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'division_id' => 'required',
            'parent_id'   => 'nullable',
            'username'    => ['required', Rule::unique('users')],
            'email'       => ['required', Rule::unique('users')],
            'password'    => 'required',
            // detail
            'nama_depan'    => 'required',
            'nama_belakang' => 'required',
            'image'         => 'nullable|image|mimes:png,jpeg,jpg|max:500000',
            'alamat'        => 'nullable',
            'phone'         => 'nullable',
            'jenis_kelamin' => 'nullable',
            'tanggal_lahir' => 'nullable',
            'tanggal_masuk' => 'nullable'
        ];
    }
}
