<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\patients;

class PatientsController extends Controller
{
    #membuat method index
    public function index()
    {
        $patients = Patients::all();
        if ($patients) {
            $data = [
                "message" => 'Get All Resource',
                'data' => $patients,
            ];
            #mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
            ];
            #mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }
    #membuat method store
    public function store(Request $request)
    {
        #membuat validasi
        $validateData = $request->validate([
            #kolom => 'rules\rules'
            'name' => 'required',
            'phone' => 'reqquired|numeric',
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => 'required',
            'out_date_at' => 'required',
        ]);
        #menggunakan model student untuk insert data
        $patients = Patients::create($validateData);
        if ($patients) {
            $data = [
                'message' => 'Resource is added successfully',
                'data' => $patients,
            ];
            #mengembalikan data (json) dan kode 201
            return response()->json($data, 201);
        } else {
            $data = [

                'message' => 'Resource not found',
            ];
            #mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    #membuat method show
    public function show($id)
    {
        #cari id patients yang ingin di liat
        $patients = Patients::find($id);
        if ($patients) {
            $data = [
                'message' => 'Get Detail Resource',
                'data' => $patients,
            ];
            #mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
            ];
            #mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }
    #membuat method update
    public function update(Request $request, $id)
    {
        #cari id patients yang ingin update
        $patients = Patients::find($id);
        if ($patients) {
            #menangkap data request
            $input = [
                'name' => $request->name ?? $patients->name,
                'phone' => $request->phone ?? $patients->phone,
                'address' => $request->address ?? $patients->address,
                'status' => $request->status ?? $patients->status,
                'in_date_at' => $request->in_date_at ?? $patients->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patients->out_date_at,
            ];
            #melakukan update data patients
            $patients->update($input);

            $data = [
                'message' => 'Resource is update succesfully',
                'data' => $patients,
            ];
            #mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
            ];
            #mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }
    #membuat method destroy
    public function destroy($id)
    {
        #cari id patients yang ingin dihapus
        $patients = Patients::find($id);
        if ($patients) {
            #menghapus data patient
            $patients->delete();
            $data = [
                'message' => 'Resource is deleted succesfully',
            ];
            #mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
            ];
            #mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }
    #membuat method search
    public function search(Request $request)
{
    $name = $request->input('name');

    // Melakukan pencarian berdasarkan nama menggunakan Eloquent
    $patients = Patients::where('name', 'like', '%' . $name . '%')->get();

    if (!$patients->isEmpty()) {
        $data = [
            'message' => 'Get Searched Resource ' . $name,
            'data' => $patients,
        ];
        // Mengembalikan data (json) dan kode 200
        return response()->json($data, 200);
    } else {
        $data = [
            'message' => 'resource not found' . $name,
        ];
        // Mengembalikan data (json) dan kode 404
        return response()->json($data, 404);
    }
}
#membuat method positive
public function positive()
{
    // Melakukan pencarian berdasarkan status positif menggunakan Eloquent
    $positivePatients = Patients::where('status', 'positive')->get();

    // Menghitung total resource yang positif
    $totalPositivePatients = $positivePatients->count();

    $data = [
        'message' => 'Get positive resource',
        'total' => $totalPositivePatients,
        'data' => $positivePatients,
    ];

    // Mengembalikan data (json) dan kode 200
    return response()->json($data, 200);
}

#membuad method recovered
public function recovered()
{
    // Melakukan pencarian berdasarkan status sembuh menggunakan Eloquent
    $recoveredPatients = Patients::where('status', 'recovered')->get();

    // Menghitung total resource yang sembuh
    $totalRecoveredPatients = $recoveredPatients->count();

    $data = [
        'message' => 'Get recovered resource',
        'total' => $totalRecoveredPatients,
        'data' => $recoveredPatients,
    ];

    // Mengembalikan data (json) dan kode 200
    return response()->json($data, 200);
}

#membuat method dead
public function dead()
{
    // Melakukan pencarian berdasarkan status meninggal menggunakan Eloquent
    $deadPatients = Patients::where('status', 'dead')->get();

    // Menghitung total resource yang meninggal
    $totalDeadPatients = $deadPatients->count();

    $data = [
        'message' => 'Get dead resource',
        'total' => $totalDeadPatients,
        'data' => $deadPatients,
    ];

    // Mengembalikan data (json) dan kode 200
    return response()->json($data, 200);
}


}
