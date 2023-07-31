<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
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

    public function create(Request $request)
    {
        try {
            $request->validate([
                'gender' => ['required', 'string', 'in:laki-laki,perempuan'],
                'tanggal_lahir' => ['required', 'date'],
                'whatsapp' => ['required', 'string', 'max:255'],
                'provinsi' => ['required', 'string', 'max:255'],
                'kota' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string'],
                'pas_photo' => ['required', 'image', 'mimes:jpeg, png, jpg']
            ]);


            $filePhoto = $request->file('pas_photo');
            $fileName = $filePhoto->getClientOriginalName();
            $publicPath = public_path('storage/photos');
            $filePhoto->move($publicPath, $fileName);
            $pathPhoto = 'storage/photos/' . $fileName;


            $new_user_info = UserInfo::create([
                'user_id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'gender' => $request->gender,
                'tanggal_lahir' => $request->tanggal_lahir,
                'whatsapp' => $request->whatsapp,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'alamat' => $request->alamat,
                'pas_photo' => $pathPhoto,
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
