<?php
namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::all();
        return response()->json($karyawan);
    }

    public function show($id)
    {
        $karyawan = Karyawan::find($id);
        return response()->json($karyawan);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $karyawan = Karyawan::create($request->all());

        return response()->json($karyawan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $karyawan = Karyawan::find($id);
        $karyawan->update($request->all());

        return response()->json($karyawan);
    }

    public function delete($id)
    {
        $karyawan = Karyawan::find($id);
        $karyawan->delete();

        return response()->json(['message' => 'Karyawan deleted']);
    }

    public function getKaryawan()
    {
        $karyawan = Karyawan::all();
        return response()->json($karyawan);
    }
}