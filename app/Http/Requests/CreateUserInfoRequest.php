<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateUserInfoRequest extends FormRequest
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
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'nama_bapak' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'kelamin' => 'required|in:laki-laki,perempuan',
            'ttl' => 'required|string|max:255',
            'no_paspor' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'no_hp_lain' => 'nullable|string|max:255',
            'nama_sekolah' => 'required|string|max:255',
            'kota_sekolah' => 'required|string|max:255',
            'pas_photo' => 'required|image|mimes:png,jpg,jpeg,JPG',
            'ijazah' => 'required|file|mimes:pdf',
            'transkrip' => 'required|file|mimes:pdf',
            'paspor' => 'required|file|mimes:pdf',
            'surat_rekomendasi' => 'required|file|mimes:pdf',
            'surat_izin' => 'required|file|mimes:pdf',
        ];
    }
}
