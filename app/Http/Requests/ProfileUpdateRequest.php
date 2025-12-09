<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
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
        $userId = $this->user()->id;

        return [
            // Karena ini HANYA UNTUK OWNER, kita tidak perlu 'sometimes' lagi 
            // jika Anda memanggilnya dari updateProfile yang terpisah dari updatePassword.
            // Namun, karena kode blade Anda menggunakan DUA FORM TERPISAH, kita harus mempertahankan 'sometimes'.
            
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => [
                'sometimes',
                'required', 
                'string', 
                'email', 
                'max:255',
                // Pastikan email unik, kecuali email milik user ini
                Rule::unique('users')->ignore($userId),
            ],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Max 2MB
            
            // Password bersifat nullable, hanya divalidasi jika diisi
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
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
            // Nama
            'name.required' => 'Nama harus diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',
            
            // Email
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh user lain.',
            
            // Avatar
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.mimes' => 'Format gambar harus: jpg, jpeg, atau png.',
            'avatar.max' => 'Ukuran gambar maksimal 2MB.',
            
            // Password
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}