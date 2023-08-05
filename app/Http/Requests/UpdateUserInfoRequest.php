<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama_depan' => 'nullable|string|max:255',
            'nama_belakang' => 'nullable|string|max:255',
            'nama_bapak' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'kelamin' => 'nullable|in:laki-laki,perempuan',
            'ttl' => 'nullable|string|max:255',
            'no_paspor' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:255',
            'no_hp_lain' => 'nullable|string|max:255',
            'nama_sekolah' => 'nullable|string|max:255',
            'kota_sekolah' => 'nullable|string|max:255',
            'pas_photo' => 'nullable|image|mimes:png,jpg,jpeg',
            'ijazah' => 'nullable|file|mimes:pdf',
            'transkrip' => 'nullable|file|mimes:pdf',
            'paspor' => 'nullable|file|mimes:pdf',
            'surat_rekomendasi' => 'nullable|file|mimes:pdf',
            'surat_izin' => 'nullable|file|mimes:pdf',
        ];
    }
}
