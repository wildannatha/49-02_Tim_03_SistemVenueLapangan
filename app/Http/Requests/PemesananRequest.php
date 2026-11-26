<?php

namespace App\Http\Requests;

use App\Models\Pemesanan;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi bersama untuk tambah & edit pemesanan.
 * Hak akses sudah dicek di route (->can), jadi di sini selalu true.
 */
class PemesananRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** Jumlah alat yang dikosongkan dianggap 0. */
    protected function prepareForValidation(): void
    {
        $defaults = [];

        foreach (array_keys(Pemesanan::ALAT) as $alat) {
            if ($this->input($alat) === null || $this->input($alat) === '') {
                $defaults[$alat] = 0;
            }
        }

        $this->merge($defaults);
    }

    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        $rules = [
            'nama' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'jam' => ['required', 'date_format:H:i'],
        ];

        foreach (array_keys(Pemesanan::ALAT) as $alat) {
            $rules[$alat] = ['required', 'integer', 'min:0', 'max:99'];
        }

        return $rules;
    }
}
