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
use Illuminate\Support\Facades\Storage;
use stdClass;

class StudentController extends Controller
{
    public function fetch(Request $request)
    {

        $user_id = $request->user()->id;

        $student = Student::where('user_id', $user_id)->with('kotaTurki', 'universitasTurki', 'jurusan')->first();

        if (!$student) {

            $student = Student::create([
                'user_id' => $user_id,
                'name' => $request->user()->name,
                'email' => $request->user()->email
            ]);

            $student = Student::query()->where('user_id', $user_id)->first();

            return ResponseFormatter::success($student, 'Fetch success');
        }

        return ResponseFormatter::success($student, 'Fetch success');
    }

    public function fetch_students(Request $request)
    {
        $limit = $request->input('limit', 100);

        $user_id = $request->input('user_id');
        $name = $request->input('name');
        $status_id = $request->input('status_id');
        $jenis_kelamin = $request->input('jenis_kelamin');
        $kota_asal_indonesia = $request->input('kota_asal_indonesia');
        $kota_turki_id = $request->input('kota_turki_id');
        $tahun_kedatangan = $request->input('tahun_kedatangan');
        $universitas_turki_id = $request->input('universitas_turki_id');
        $jenjang_pendidikan = $request->input('jenjang_pendidikan');
        $tahun_ke = $request->input('tahun_ke');

        $order_field = $request->input('order_field');
        $order_by = $request->input('order_by');

        $students = Student::with('kotaTurki', 'status', 'jurusan', 'universitasTurki');

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

        if ($status_id) {
            $students->where('status_id', $status_id);
        }

        if ($jenis_kelamin) {
            $students->where('jenis_kelamin', $jenis_kelamin);
        }

        if ($kota_asal_indonesia) {
            $students->where('kota_asal_indonesia', $kota_asal_indonesia);
        }

        if ($tahun_kedatangan) {
            $students->where('tahun_kedatangan', 'like', $tahun_kedatangan . '%');
        }

        if ($kota_turki_id) {
            $students->where('kota_turki_id', $kota_turki_id);
        }

        if ($universitas_turki_id) {
            $students->where('universitas_turki_id', $universitas_turki_id);
        }

        if ($jenjang_pendidikan) {
            $students->where('jenjang_pendidikan', $jenjang_pendidikan);
        }

        if ($tahun_ke) {
            $students->where('tahun_ke', $tahun_ke);
        }

        if ($order_field && $order_by) $students->orderBy($order_field, $order_by);

        return ResponseFormatter::success($students->paginate($limit), 'Students datas found');
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
                if ($student->photo)
                    unlink(public_path($student->photo));

                $filePhoto = $studentRequest->file('photo');

                $fileName = $filePhoto->getClientOriginalName();

                $publicPath = public_path('storage/photos');

                $filePhoto->move($publicPath, $fileName);

                $pathPhoto = 'storage/photos/' . $fileName;
            }

            if ($studentRequest->hasFile('ikamet_file')) {
                if ($student->ikamet_file)
                    unlink(public_path($student->ikamet_file));

                $fileIkamet = $studentRequest->file('ikamet_file');

                $fileName = $fileIkamet->getClientOriginalName();

                $publicPath = public_path('storage/ikamet');

                $fileIkamet->move($publicPath, $fileName);

                $pathIkamet = 'storage/ikamet/' . $fileName;
            }

            if ($studentRequest->hasFile('ogrenci_belgesi')) {
                if ($student->ogrenci_belgesi)
                    unlink(public_path($student->ogrenci_belgesi));

                $fileObel = $studentRequest->file('ogrenci_belgesi');

                $fileName = $fileObel->getClientOriginalName();

                $publicPath = public_path('storage/obel');

                $fileObel->move($publicPath, $fileName);

                $pathObel = 'storage/obel/' . $fileName;
            }

            // updating
            $student->update([
                'name' => isset($studentRequest->name) ? $studentRequest->name : $student->name,
                'email' => isset($studentRequest->email) ? $studentRequest->email : $student->email,
                'status_id' => isset($studentRequest->status_id) ? $studentRequest->status_id : $student->status_id,
                'jenis_kelamin' => isset($studentRequest->jenis_kelamin) ? $studentRequest->jenis_kelamin : $student->jenis_kelamin,
                'kimlik_exp' => isset($studentRequest->kimlik_exp) ? $studentRequest->kimlik_exp : $student->kimlik_exp,
                'tanggal_lahir' => isset($studentRequest->tanggal_lahir) ? $studentRequest->tanggal_lahir : $student->tanggal_lahir,
                'provinsi_indonesia' => isset($studentRequest->provinsi_indonesia) ? $studentRequest->provinsi_indonesia : $student->provinsi_indonesia,
                'kota_asal_indonesia' => isset($studentRequest->kota_asal_indonesia) ? $studentRequest->kota_asal_indonesia : $student->kota_asal_indonesia,
                'alamat_lengkap_indonesia' => isset($studentRequest->alamat_lengkap_indonesia) ? $studentRequest->alamat_lengkap_indonesia : $student->alamat_lengkap_indonesia,
                'tempat_tinggal' => isset($studentRequest->tempat_tinggal) ? $studentRequest->tempat_tinggal : $student->tempat_tinggal,
                'kota_turki_id' => isset($studentRequest->kota_turki_id) ? $studentRequest->kota_turki_id : $student->kota_turki_id,
                'alamat_turki' => isset($studentRequest->alamat_turki) ? $studentRequest->alamat_turki : $student->alamat_turki,
                'whatsapp' => isset($studentRequest->whatsapp) ? $studentRequest->whatsapp : $student->whatsapp,
                'no_aktif' => isset($studentRequest->no_aktif) ? $studentRequest->no_aktif : $student->no_aktif,
                'tahun_kedatangan' => isset($studentRequest->tahun_kedatangan) ? $studentRequest->tahun_kedatangan : $student->tahun_kedatangan,
                'photo' => isset($pathPhoto) ? $pathPhoto : $student->photo,
                'no_paspor' => isset($studentRequest->no_paspor) ? $studentRequest->no_paspor : $student->no_paspor,
                'paspor_exp' => isset($studentRequest->paspor_exp) ? $studentRequest->paspor_exp : $student->paspor_exp,
                'tc_kimlik' => isset($studentRequest->tc_kimlik) ? $studentRequest->tc_kimlik : $student->tc_kimlik,
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

    public function updateStudents(Request $request)
    {
        try {
            if ($request->user()->role_id != 1)
                return ResponseFormatter::error('Request access denied!');

            $IDs = $request->input('id');
            $status_id = $request->input('status_id');

            if (!$IDs)
                return ResponseFormatter::error('ID is required!');

            $IDs = explode(',', $IDs);
            $users = Student::query()->whereIn('id', $IDs);

            if ($status_id)
                $users->update(['status_id' => $status_id]);


            return ResponseFormatter::success(null, 'Updates successful');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function fetch_statistic()
    {
        try {
            $year = array();
            $student_bartin = array();
            $student_karabuk = array();
            $student_zonguldak = array();

            for ($i = -5; $i < 1; $i++) {
                $year[$i + 5] = date('Y', strtotime("$i year"));

                $object = new stdClass;
                $object->label = $year[$i + 5];
                $object->count = Student::where('kota_turki_id', 1)->where('tahun_kedatangan', '<=', $year[$i + 5])->count();

                $student_bartin[$i + 5] = $object;
            }

            for ($i = -5; $i < 1; $i++) {
                $object = new stdClass;
                $object->label = $year[$i + 5];
                $object->count = Student::where('kota_turki_id', 2)->where('tahun_kedatangan', '<=', $year[$i + 5])->count();

                $student_karabuk[$i + 5] = $object;
            }

            for ($i = -5; $i < 1; $i++) {
                $object = new stdClass;
                $object->label = $year[$i + 5];
                $object->count = Student::where('kota_turki_id', 3)->where('tahun_kedatangan', '<=', $year[$i + 5])->count();

                $student_zonguldak[$i + 5] = $object;
            }



            $jurusan = Student::selectRaw('jurusan_id, COUNT(*) as count')
                ->whereNotNull('jurusan_id')
                ->groupBy('jurusan_id')
                ->orderByDesc('count')
                ->take(3)
                ->with('jurusan')
                ->get();

            $kota = Student::selectRaw('kota_turki_id, COUNT(*) as count')
                ->whereNotNull('kota_turki_id')
                ->groupBy('kota_turki_id')
                ->with('kotaTurki')
                ->get();

            $jenjang_pendidikan = Student::selectRaw('jenjang_pendidikan, COUNT(*) as count')
                ->whereNotNull('jenjang_pendidikan')
                ->groupBy('jenjang_pendidikan')
                ->orderBy('jenjang_pendidikan')
                ->get();

            $asal_kota = Student::selectRaw('kota_asal_indonesia, COUNT(*) as count')
                ->whereNotNull('kota_asal_indonesia')
                ->groupBy('kota_asal_indonesia')
                ->orderByDesc('count')
                ->take(3)
                ->get();

            $gender = Student::selectRaw('jenis_kelamin, COUNT(*) as count')
                ->whereNotNull('jenis_kelamin')
                ->groupBy('jenis_kelamin')
                ->orderByDesc('count')
                ->get();

            $status = Student::selectRaw('status_id, COUNT(*) as count')
                ->groupBy('status_id')
                ->orderByDesc('count')
                ->with('status')
                ->get();

            $active_student = Student::where('status_id', 1)->count();

            $data = new stdClass;
            $data->student = new stdClass;
            $data->student->label = $year;
            $data->student->bartin = $student_bartin;
            $data->student->karabuk = $student_karabuk;
            $data->student->zonguldak = $student_zonguldak;
            $data->status = $status;
            $data->jurusan = $jurusan;
            $data->jenjang_pendidikan = $jenjang_pendidikan;
            $data->kota = $kota;
            $data->asal_kota = $asal_kota;
            $data->gender = $gender;
            $data->gender = $gender;
            $data->active_student = $active_student;

            return ResponseFormatter::success($data, 'Fetched successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
