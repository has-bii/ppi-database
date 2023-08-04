<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserInfoRequest;
use App\Models\UserInfo;
use Exception;
use Illuminate\Http\Request;

class UserInfoController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            $limit = $request->input('limit', 100);
            $user_id = $request->input('user_id');
            $name = $request->input('name');

            // Get one data
            if ($user_id) {
                $user_info = UserInfo::query()->where('user_id', $user_id)->first();
                return ResponseFormatter::success($user_info, 'User info fetched successfully');
            }

            // Get all data
            $user_infos = UserInfo::query();
            if ($name) {
                $user_infos->where('name', 'like', '%' . $name . '%');
            }

            return ResponseFormatter::success($user_infos->paginate($limit), 'User info fetched successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    public function create(Request $request, CreateUserInfoRequest $createUserInfoRequest)
    {
        try {

            // Pas photo
            $filePhoto = $createUserInfoRequest->file('pas_photo');
            $fileName = $filePhoto->getClientOriginalName();
            $publicPath = public_path('storage/photos');
            $filePhoto->move($publicPath, $fileName);
            $pathPhoto = 'storage/photos/' . $fileName;

            // Pas ijazah
            $filePhoto = $createUserInfoRequest->file('ijazah');
            $fileName = $filePhoto->getClientOriginalName();
            $publicPath = public_path('storage/files');
            $filePhoto->move($publicPath, $fileName);
            $pathIjazah = 'storage/files/' . $fileName;

            // Pas transkrip
            $filePhoto = $createUserInfoRequest->file('transkrip');
            $fileName = $filePhoto->getClientOriginalName();
            $publicPath = public_path('storage/files');
            $filePhoto->move($publicPath, $fileName);
            $pathTranskrip = 'storage/files/' . $fileName;

            // Pas paspor
            $filePhoto = $createUserInfoRequest->file('paspor');
            $fileName = $filePhoto->getClientOriginalName();
            $publicPath = public_path('storage/files');
            $filePhoto->move($publicPath, $fileName);
            $pathPaspor = 'storage/files/' . $fileName;

            // Pas surat_rekomendasi
            $filePhoto = $createUserInfoRequest->file('surat_rekomendasi');
            $fileName = $filePhoto->getClientOriginalName();
            $publicPath = public_path('storage/files');
            $filePhoto->move($publicPath, $fileName);
            $pathSuratRekomendasi = 'storage/files/' . $fileName;

            // Pas surat_izin
            $filePhoto = $createUserInfoRequest->file('surat_izin');
            $fileName = $filePhoto->getClientOriginalName();
            $publicPath = public_path('storage/files');
            $filePhoto->move($publicPath, $fileName);
            $pathSuratIzin = 'storage/files/' . $fileName;

            $new_user_info = UserInfo::create([
                'user_id' => $request->user()->id,
                'nama_depan' => $createUserInfoRequest->nama_depan,
                'nama_belakang' => $createUserInfoRequest->nama_belakang,
                'nama_bapak' => $createUserInfoRequest->nama_bapak,
                'nama_ibu' => $createUserInfoRequest->nama_ibu,
                'kelamin' => $createUserInfoRequest->kelamin,
                'ttl' => $createUserInfoRequest->ttl,
                'no_paspor' => $createUserInfoRequest->no_paspor,
                'provinsi' => $createUserInfoRequest->provinsi,
                'kota' => $createUserInfoRequest->kota,
                'alamat' => $createUserInfoRequest->alamat,
                'email' => $createUserInfoRequest->email,
                'no_hp' => $createUserInfoRequest->no_hp,
                'no_hp_lain' => $createUserInfoRequest->no_hp_lain,
                'nama_sekolah' => $createUserInfoRequest->nama_sekolah,
                'kota_sekolah' => $createUserInfoRequest->kota_sekolah,
                'pas_photo' => $pathPhoto,
                'ijazah' => $pathIjazah,
                'transkrip' => $pathTranskrip,
                'paspor' => $pathPaspor,
                'surat_rekomendasi' => $pathSuratRekomendasi,
                'surat_izin' => $pathSuratIzin,
            ]);

            if (!$new_user_info)
                throw new Exception('Error: Cannot create data to server!');

            return ResponseFormatter::success($new_user_info, 'Created data successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    public function update(Request $request)
    {
        try {

            $user_info = UserInfo::query()->where('user_id', $request->user()->id)->first();

            if (!$user_info)
                throw new Exception('User info not found!');

            $request->validate([
                'gender' => ['string', 'in:laki-laki,perempuan'],
                'tanggal_lahir' => ['date'],
                'whatsapp' => ['string', 'max:255'],
                'provinsi' => ['string', 'max:255'],
                'kota' => ['string', 'max:255'],
                'alamat' => ['string'],
                'pas_photo' => ['image', 'mimes:jpeg, png, jpg']
            ]);

            $gender = $request->input('gender');
            $tanggal_lahir = $request->input('tanggal_lahir');
            $whatsapp = $request->input('whatsapp');
            $provinsi = $request->input('provinsi');
            $kota = $request->input('kota');
            $alamat = $request->input('alamat');

            if ($request->hasFile('pas_photo')) {
                if ($user_info->photo)
                    unlink(public_path($user_info->photo));

                $filePhoto = $request->file('pas_photo');
                $fileName = $filePhoto->getClientOriginalName();
                $publicPath = public_path('storage/photos');
                $filePhoto->move($publicPath, $fileName);
                $pathPhoto = 'storage/photos/' . $fileName;

                $user_info->pas_photo = $pathPhoto;
            }

            if ($gender)
                $user_info->gender = $gender;

            if ($tanggal_lahir)
                $user_info->tanggal_lahir = $tanggal_lahir;

            if ($whatsapp)
                $user_info->whatsapp = $whatsapp;

            if ($provinsi)
                $user_info->provinsi = $provinsi;

            if ($kota)
                $user_info->kota = $kota;

            if ($alamat)
                $user_info->alamat = $alamat;

            $user_info->save();

            return ResponseFormatter::success($user_info, 'Updated data successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }
}
