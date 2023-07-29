<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewStudentRequest;
use App\Http\Requests\TestRequest;
use App\Models\NewStudent;
use Exception;
use Illuminate\Http\Request;

class NewStudentController extends Controller
{

    public function fetch(Request $request)
    {
        try {
            $limit = $request->input('limit', 100);
            $id = $request->input('user_id');
            $name = $request->input('name');

            $order_field = $request->input('order_field');
            $order_by = $request->input('order_by');


            // One data
            if ($id) {
                $new_student = NewStudent::with('jurusan')->where('user_id', $id)->first();

                if ($new_student)
                    return ResponseFormatter::success($new_student, 'Fetch Success');

                $new_student = NewStudent::create([
                    'user_id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                ]);

                if (!$new_student)
                    throw new Exception('Error while creating data');

                return ResponseFormatter::success($new_student, 'Fetch Success');
            }

            // All data
            $new_students = NewStudent::query()->with('jurusan');

            if ($name) {
                $new_students->where('name', 'like', '%' . $name . '%');
            }

            if ($order_field && $order_by) $new_students->orderBy($order_field, $order_by);

            return ResponseFormatter::success($new_students->paginate($limit), 'Fetch success');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
                'tanggal_lahir' => 'required|date',
                'provinsi_indonesia' => 'required|string|max:255',
                'kota_asal_indonesia' => 'required|string|max:255',
                'alamat_lengkap_indonesia' => 'required|string|max:255',
                'whatsapp' => 'required|string|max:255',
                'no_paspor' => 'required|string|max:255',
                'jenjang_pendidikan' => 'required|string|in:Lise,S1,S2,S3',
                'jurusan_id' => 'required|integer|exists:jurusans,id',
            ]);

            $new_student = NewStudent::create([
                'user_id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'provinsi_indonesia' => $request->provinsi_indonesia,
                'kota_asal_indonesia' => $request->kota_asal_indonesia,
                'alamat_lengkap_indonesia' => $request->alamat_lengkap_indonesia,
                'whatsapp' => $request->whatsapp,
                'no_paspor' => $request->no_paspor,
                'jenjang_pendidikan' => $request->jenjang_pendidikan,
                'jurusan_id' => $request->jurusan_id
            ]);

            if (!$new_student)
                throw new Exception('New Student is not created!');

            return ResponseFormatter::success($new_student, 'Data created');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
                'tanggal_lahir' => 'required|date',
                'provinsi_indonesia' => 'required|string|max:255',
                'kota_asal_indonesia' => 'required|string|max:255',
                'alamat_lengkap_indonesia' => 'required|string|max:255',
                'whatsapp' => 'required|string|max:255',
                'no_paspor' => 'required|string|max:255',
                'jenjang_pendidikan' => 'required|string|in:Lise,S1,S2,S3',
                'jurusan_id' => 'required|integer|exists:jurusans,id',
            ]);

            $new_student = NewStudent::query()->where('user_id', $request->user()->id);

            if (!$new_student)
                throw new Exception('New Student not found');

            $new_student->update([
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'provinsi_indonesia' => $request->provinsi_indonesia,
                'kota_asal_indonesia' => $request->kota_asal_indonesia,
                'alamat_lengkap_indonesia' => $request->alamat_lengkap_indonesia,
                'whatsapp' => $request->whatsapp,
                'no_paspor' => $request->no_paspor,
                'jenjang_pendidikan' => $request->jenjang_pendidikan,
                'jurusan_id' => $request->jurusan_id
            ]);

            if (!$new_student)
                throw new Exception('New Student is not created!');

            return ResponseFormatter::success($new_student, 'Data updated');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
