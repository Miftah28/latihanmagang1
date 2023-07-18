<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        $id = $this->get('id');
        if ($this->method() == 'PUT') {
            $email = 'required|string|email|accepted|unique:users,email,' . $id;
            $name = 'required|string|max:255|unique:admins,name,' . $id;
            // $phone = 'required|unique:instances,phone,' . $id;
            // $photo = 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096';
        } else {
            $email = 'required|string|email|accepted|unique:users,email,NULL';
            $name = 'required|string|max:255|unique:admins,name,NULL';
            // $phone = 'required|unique:instances,phone,NULL';
            // $photo = 'required|image|mimes:jpeg,png,jpg,gif|max:4096';
        }

        return [
            'name' => $name,
            // 'instance_name' => 'required|string|max:255',
            // 'instance_address' => 'required|string',
            'email' => $email,
            // 'phone' => $phone,
            // 'photo' => $photo
        ];
    }
}
