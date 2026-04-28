<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePasienRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|digits:16|unique:pasiens,nik',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string|max:20',
        ];
    }
}
