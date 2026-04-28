<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePendaftaranRequest extends FormRequest
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
            'pasien_id' => 'required|exists:pasiens,id',
            'poli_id' => 'required|exists:polis,id',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'keluhan' => 'required|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $registrationService = new \App\Services\RegistrationService();
            if ($registrationService->hasRegisteredToday(
                $this->pasien_id,
                $this->poli_id,
                $this->tanggal_kunjungan
            )) {
                $validator->errors()->add('pasien_id', 'Pasien sudah terdaftar di poli ini pada tanggal tersebut.');
            }
        });
    }
}
