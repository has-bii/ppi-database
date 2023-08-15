<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserInfoRequest;
use App\Http\Requests\UpdateUserInfoRequest;
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
            $user_id = $request->user()->id;

            // Pas photo
            $filePhoto = $createUserInfoRequest->file('pas_photo');
            $fileName = $user_id . '_photo.' . $filePhoto->getClientOriginalExtension();
            $publicPath = public_path('storage/photos');
            $filePhoto->move($publicPath, $fileName);
            $pathPhoto = 'storage/photos/' . $fileName;

            // Pas ijazah
            $fileIjazah = $createUserInfoRequest->file('ijazah');
            $fileName = $user_id . '_ijazah.' . $fileIjazah->getClientOriginalExtension();
            $publicPath = public_path('storage/files');
            $fileIjazah->move($publicPath, $fileName);
            $pathIjazah = 'storage/files/' . $fileName;

            // Pas transkrip
            $fileTranskrip = $createUserInfoRequest->file('transkrip');
            $fileName = $user_id . '_transkrip.' . $fileTranskrip->getClientOriginalExtension();
            $publicPath = public_path('storage/files');
            $fileTranskrip->move($publicPath, $fileName);
            $pathTranskrip = 'storage/files/' . $fileName;

            // Pas paspor
            $filePaspor = $createUserInfoRequest->file('paspor');
            $fileName = $user_id . '_paspor.' . $filePaspor->getClientOriginalExtension();
            $publicPath = public_path('storage/files');
            $filePaspor->move($publicPath, $fileName);
            $pathPaspor = 'storage/files/' . $fileName;

            // Pas surat_rekomendasi
            $fileRekomendasi = $createUserInfoRequest->file('surat_rekomendasi');
            $fileName = $user_id . '_rekomendasi.' . $fileRekomendasi->getClientOriginalExtension();
            $publicPath = public_path('storage/files');
            $fileRekomendasi->move($publicPath, $fileName);
            $pathSuratRekomendasi = 'storage/files/' . $fileName;

            // Pas surat_izin
            $fileIzin = $createUserInfoRequest->file('surat_izin');
            $fileName = $user_id . '_izin.' . $fileIzin->getClientOriginalExtension();
            $publicPath = public_path('storage/files');
            $fileIzin->move($publicPath, $fileName);
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

    public function update(Request $request, UpdateUserInfoRequest $updateUserInfoRequest)
    {
        try {

            $user_id = $request->user()->id;

            $user_info = UserInfo::query()->where('user_id', $request->user()->id)->first();

            if (!$user_info)
                throw new Exception('User info not found!');

            if ($updateUserInfoRequest->hasFile('pas_photo')) {
                if ($user_info->pas_photo)
                    unlink(public_path($user_info->pas_photo));

                $filePhoto = $updateUserInfoRequest->file('pas_photo');
                $fileName = $user_id . '_photo.' . $filePhoto->getClientOriginalExtension();
                $publicPath = public_path('storage/photos');
                $filePhoto->move($publicPath, $fileName);
                $pathPhoto = 'storage/photos/' . $fileName;

                $user_info->pas_photo = $pathPhoto;
            }

            if ($updateUserInfoRequest->hasFile('ijazah')) {
                if ($user_info->ijazah)
                    unlink(public_path($user_info->ijazah));

                $fileIjazah = $updateUserInfoRequest->file('ijazah');
                $fileName = $user_id . '_ijazah.' . $fileIjazah->getClientOriginalExtension();
                $publicPath = public_path('storage/files');
                $fileIjazah->move($publicPath, $fileName);
                $pathIjazah = 'storage/files/' . $fileName;

                $user_info->ijazah = $pathIjazah;
            }

            if ($updateUserInfoRequest->hasFile('transkrip')) {
                if ($user_info->transkrip)
                    unlink(public_path($user_info->transkrip));

                $fileTranskrip = $updateUserInfoRequest->file('transkrip');
                $fileName = $user_id . '_transkrip.' . $fileTranskrip->getClientOriginalExtension();
                $publicPath = public_path('storage/files');
                $fileTranskrip->move($publicPath, $fileName);
                $pathTranskrip = 'storage/files/' . $fileName;

                $user_info->transkrip = $pathTranskrip;
            }

            if ($updateUserInfoRequest->hasFile('paspor')) {
                if ($user_info->paspor)
                    unlink(public_path($user_info->paspor));

                $filePaspor = $updateUserInfoRequest->file('paspor');
                $fileName = $user_id . '_paspor.' . $filePaspor->getClientOriginalExtension();
                $publicPath = public_path('storage/files');
                $filePaspor->move($publicPath, $fileName);
                $pathPaspor = 'storage/files/' . $fileName;

                $user_info->paspor = $pathPaspor;
            }

            if ($updateUserInfoRequest->hasFile('surat_rekomendasi')) {
                if ($user_info->surat_rekomendasi)
                    unlink(public_path($user_info->surat_rekomendasi));

                $fileSuratRekomendasi = $updateUserInfoRequest->file('surat_rekomendasi');
                $fileName = $user_id . '_rekomendasi.' . $fileSuratRekomendasi->getClientOriginalExtension();
                $publicPath = public_path('storage/files');
                $fileSuratRekomendasi->move($publicPath, $fileName);
                $pathSuratRekomendasi = 'storage/files/' . $fileName;

                $user_info->surat_rekomendasi = $pathSuratRekomendasi;
            }

            if ($updateUserInfoRequest->hasFile('surat_izin')) {
                if ($user_info->surat_izin)
                    unlink(public_path($user_info->surat_izin));

                $fileSuratIzin = $updateUserInfoRequest->file('surat_izin');
                $fileName = $user_id . '_izin.' . $fileSuratIzin->getClientOriginalExtension();
                $publicPath = public_path('storage/files');
                $fileSuratIzin->move($publicPath, $fileName);
                $pathSuratIzin = 'storage/files/' . $fileName;

                $user_info->surat_izin = $pathSuratIzin;
            }

            $user_info->nama_depan = $updateUserInfoRequest->nama_depan;
            $user_info->nama_belakang = $updateUserInfoRequest->nama_belakang;
            $user_info->nama_bapak = $updateUserInfoRequest->nama_bapak;
            $user_info->nama_ibu = $updateUserInfoRequest->nama_ibu;
            $user_info->kelamin = $updateUserInfoRequest->kelamin;
            $user_info->ttl = $updateUserInfoRequest->ttl;
            $user_info->no_paspor = $updateUserInfoRequest->no_paspor;
            $user_info->provinsi = $updateUserInfoRequest->provinsi;
            $user_info->kota = $updateUserInfoRequest->kota;
            $user_info->alamat = $updateUserInfoRequest->alamat;
            $user_info->email = $updateUserInfoRequest->email;
            $user_info->no_hp = $updateUserInfoRequest->no_hp;
            $user_info->no_hp_lain = $updateUserInfoRequest->no_hp_lain;
            $user_info->nama_sekolah = $updateUserInfoRequest->nama_sekolah;
            $user_info->kota_sekolah = $updateUserInfoRequest->kota_sekolah;

            $user_info->save();

            return ResponseFormatter::success($user_info, 'Updated data successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }
}
