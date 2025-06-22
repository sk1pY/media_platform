<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $user = auth()->user();
        return [
            'name' => 'sometimes|alpha_num|filled|unique:users,name,' . $user->id,
            'image' => 'sometimes|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_cover' => 'sometimes|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
