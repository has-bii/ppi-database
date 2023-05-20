<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function fetch(Request $request)
    {

        $student = Student::where('user_id', $request->user()->id)->with('kotaTurki', 'ppi', 'universitasTurki', 'jurusan')->first();

        if (!$student) {

            return ResponseFormatter::error('Data not found');
        }

        return ResponseFormatter::success($student, 'Data found');
    }

    public function fetch_students(Request $request)
    {
        $limit = $request->input('limit', 100);

        $user_id = $request->input('user_id');
        $name = $request->input('name');
        $email = $request->input('email');
        $jenis_kelamin = $request->input('jenis_kelamin');
        $agama = $request->input('agama');
        $provinsi_indonesia = $request->input('provinsi_indonesia');
        $kota_asal_indonesia = $request->input('kota_asal_indonesia');
        $tempat_tinggal = $request->input('tempat_tinggal');
        $kota_turki_id = $request->input('kota_turki_id');
        $tahun_masuk = $request->input('tahun_masuk');
        $ppi_id = $request->input('ppi_id');
        $no_ikamet = $request->input('no_ikamet');
        $universitas_turki_id = $request->input('universitas_turki_id');
        $jurusan_id = $request->input('jurusan_id');
        $jenjang_pendidikan = $request->input('jenjang_pendidikan');
        $tahun_ke = $request->input('tahun_ke');

        $students = Student::with('kotaTurki', 'ppi', 'universitasTurki');

        if ($user_id) {
            $student = $students->find($user_id);

            if ($student) {
                return ResponseFormatter::success($student, 'Student found');
            }

            return ResponseFormatter::error('Student not found', 404);
        }

        if ($name) {
            $students->where('name', 'like', '%' . $name . '%');
        }

        if ($email) {
            $students->where('email', $email);
        }

        if ($jenis_kelamin) {
            $students->where('jenis_kelamin', $jenis_kelamin);
        }

        if ($agama) {
            $students->where('agama', $agama);
        }

        if ($provinsi_indonesia) {
            $students->where('provinsi_indonesia', $provinsi_indonesia);
        }

        if ($kota_asal_indonesia) {
            $students->where('kota_asal_indonesia', $kota_asal_indonesia);
        }

        if ($tempat_tinggal) {
            $students->where('tempat_tinggal', $tempat_tinggal);
        }

        if ($tahun_masuk) {
            $students->where('tahun_masuk', $tahun_masuk);
        }

        if ($kota_turki_id) {
            $students->where('kota_turki_id', $kota_turki_id);
        }

        if ($ppi_id) {
            $students->where('ppi_id', $ppi_id);
        }

        if ($no_ikamet) {
            $students->where('no_ikamet', 'like', '%' . $no_ikamet . '%');
        }

        if ($universitas_turki_id) {
            $students->where('universitas_turki_id', $universitas_turki_id);
        }

        if ($jurusan_id) {
            $students->where('jurusan_id', $jurusan_id);
        }

        if ($jenjang_pendidikan) {
            $students->where('jenjang_pendidikan', $jenjang_pendidikan);
        }

        if ($tahun_ke) {
            $students->where('tahun_ke', $tahun_ke);
        }

        if (!$students) {

            return ResponseFormatter::error('No students data found');
        }

        return ResponseFormatter::success($students->paginate($limit), 'Students datas found');
    }

    public function fetch_students_count()
    {

        $count = Student::where('ppi_id', 1)->get()->count();

        return ResponseFormatter::success($count, 'Data found');
    }

    public function update(Request $request, UpdateStudentRequest $studentRequest)
    {
        try {

            // Student
            $student = Student::where('user_id', $request->user()->id)->first();

            if (!$student) {
                throw new Exception('Student not found');
            }

            if ($studentRequest->hasFile('photo')) {
                $filePhoto = $studentRequest->file('photo');

                $userName = $request->user()->id;
                $fileName = $userName . '_img.' . $filePhoto->getClientOriginalExtension();

                $publicPath = public_path('storage/photos');

                $filePhoto->move($publicPath, $fileName);

                $pathPhoto = 'storage/photos/' . $fileName;
            }

            if ($studentRequest->hasFile('ikamet_file')) {
                $fileIkamet = $studentRequest->file('ikamet_file');

                $userName = $request->user()->id;
                $fileName = $userName . '_ikamet.' . $fileIkamet->getClientOriginalExtension();

                $publicPath = public_path('storage/ikamet');

                $fileIkamet->move($publicPath, $fileName);

                $pathIkamet = 'storage/ikamet/' . $fileName;
            }

            if ($studentRequest->hasFile('ogrenci_belgesi')) {
                $fileObel = $studentRequest->file('ogrenci_belgesi');

                $userName = $request->user()->id;
                $fileName = $userName . '_obel.' . $fileObel->getClientOriginalExtension();

                $publicPath = public_path('storage/obel');

                $fileObel->move($publicPath, $fileName);

                $pathObel = 'storage/obel/' . $fileName;
            }

            // updating
            $student->update([
                'name' => isset($studentRequest->name) ? $studentRequest->name : $student->name,
                'email' => isset($studentRequest->email) ? $studentRequest->email : $student->email,
                'jenis_kelamin' => isset($studentRequest->jenis_kelamin) ? $studentRequest->jenis_kelamin : $student->jenis_kelamin,
                'agama' => isset($studentRequest->agama) ? $studentRequest->agama : $student->agama,
                'tempat_lahir' => isset($studentRequest->tempat_lahir) ? $studentRequest->tempat_lahir : $student->tempat_lahir,
                'tanggal_lahir' => isset($studentRequest->tanggal_lahir) ? Carbon::createFromFormat('Y-m-d', $studentRequest->tanggal_lahir)->format('Y-m-d') : $student->tanggal_lahir,
                'provinsi_indonesia' => isset($studentRequest->provinsi_indonesia) ? $studentRequest->provinsi_indonesia : $student->provinsi_indonesia,
                'kota_asal_indonesia' => isset($studentRequest->kota_asal_indonesia) ? $studentRequest->kota_asal_indonesia : $student->kota_asal_indonesia,
                'alamat_lengkap_indonesia' => isset($studentRequest->alamat_lengkap_indonesia) ? $studentRequest->alamat_lengkap_indonesia : $student->alamat_lengkap_indonesia,
                'tempat_tinggal' => isset($studentRequest->tempat_tinggal) ? $studentRequest->tempat_tinggal : $student->tempat_tinggal,
                'kota_turki_id' => isset($studentRequest->kota_turki_id) ? $studentRequest->kota_turki_id : $student->kota_turki_id,
                'alamat_turki' => isset($studentRequest->alamat_turki) ? $studentRequest->alamat_turki : $student->alamat_turki,
                'whatsapp' => isset($studentRequest->whatsapp) ? $studentRequest->whatsapp : $student->whatsapp,
                'no_aktif' => isset($studentRequest->no_aktif) ? $studentRequest->no_aktif : $student->no_aktif,
                'tahun_masuk' => isset($studentRequest->tahun_masuk) ? $studentRequest->tahun_masuk : $student->tahun_masuk,
                'ppi_id' => isset($studentRequest->ppi_id) ? $studentRequest->ppi_id : $student->ppi_id,
                'photo' => isset($pathPhoto) ? $pathPhoto : $student->photo,
                'no_ikamet' => isset($studentRequest->no_ikamet) ? $studentRequest->no_ikamet : $student->no_ikamet,
                'ikamet_file' => isset($pathIkamet) ? $pathIkamet : $student->ikamet_file,
                'ogrenci_belgesi' => isset($pathObel) ? $pathObel : $student->ogrenci_belgesi,
                'universitas_turki_id' => isset($studentRequest->universitas_turki_id) ? $studentRequest->universitas_turki_id : $student->universitas_turki_id,
                'jurusan_id' => isset($studentRequest->jurusan_id) ? $studentRequest->jurusan_id : $student->jurusan_id,
                'jenjang_pendidikan' => isset($studentRequest->jenjang_pendidikan) ? $studentRequest->jenjang_pendidikan : $student->jenjang_pendidikan,
                'tahun_ke' => isset($studentRequest->tahun_ke) ? $studentRequest->tahun_ke : $student->tahun_ke,
            ]);

            // User
            $user = User::find($request->user()->id);

            if ($studentRequest->name) {
                $user->name = $studentRequest->name;
            }

            if ($studentRequest->email) {
                $user->email = $studentRequest->email;
            }

            $user->save();

            return ResponseFormatter::success([$student, $user], 'Student data updated');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage());
        }
    }
}
