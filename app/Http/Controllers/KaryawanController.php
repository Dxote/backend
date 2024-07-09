<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $karyawan = Karyawan::paginate($perPage);
        return response()->json($karyawan);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        $karyawan = Karyawan::create($request->all());

        return response()->json($karyawan, 201);
    }

    public function show($id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json(['message' => 'Karyawan not found'], 404);
        }

        return response()->json($karyawan);
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json(['message' => 'Karyawan not found'], 404);
        }

        $karyawan->update($request->all());

        return response()->json($karyawan);
    }

    public function delete($id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json(['message' => 'Karyawan not found'], 404);
        }

        $karyawan->delete();

        return response()->json(['message' => 'Karyawan deleted successfully']);
    }
}
