<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
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
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|string|max:255',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'agama' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'provinsi_indonesia' => 'nullable|string|max:255',
            'kota_asal_indonesia' => 'nullable|string|max:255',
            'alamat_lengkap_indonesia' => 'nullable|string|max:255',
            'tempat_tinggal' => 'nullable|string|max:255',
            'kota_turki_id' => 'nullable|integer',
            'alamat_turki' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'no_aktif' => 'nullable|string|max:255',
            'tahun_kedatangan' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,gif,svg,png,jpg',
            'tc_kimlik' => 'nullable|string|max:255',
            'no_paspor' => 'nullable|string|max:255',
            'paspor_exp' => 'nullable|date',
            'ikamet_file' => 'nullable|file|mimes:pdf',
            'ogrenci_belgesi' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'universitas_turki_id' => 'nullable|integer',
            'jurusan_id' => 'nullable|integer',
            'jenjang_pendidikan' => 'nullable|string|in:Lise,S1,S2,S3',
            'tahun_ke' => 'nullable|string|in:TÖMER,1,2,3,4,5,6',
        ];
    }
}
