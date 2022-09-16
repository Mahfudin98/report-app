<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsersRequest extends FormRequest
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
            'username'    => ['required', Rule::unique('users')->ignore($this->users)],
            'email'       => ['required', Rule::unique('users')->ignore($this->users)],
            'nama_depan'    => 'required',
            'nama_belakang' => 'required',
            'image'         => 'nullable|image|mimes:png,jpeg,jpg|max:500000',
            'alamat'        => 'nullable',
            'phone'         => 'nullable',
            'tanggal_lahir' => 'nullable',
        ];
    }
}
