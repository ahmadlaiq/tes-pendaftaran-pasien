<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasienRequest extends FormRequest
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
        $pasienId = $this->route('pasien');
        return [
            'nama_lengkap' => 'sometimes|required|string|max:255',
            'nik' => 'sometimes|required|digits:16|unique:pasiens,nik,' . $pasienId,
            'tanggal_lahir' => 'sometimes|required|date',
            'jenis_kelamin' => 'sometimes|required|in:Laki-laki,Perempuan',
            'alamat' => 'sometimes|required|string',
            'nomor_telepon' => 'sometimes|required|string|max:20',
        ];
    }
}
