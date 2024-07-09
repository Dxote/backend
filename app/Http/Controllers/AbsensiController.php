<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{

    public function index()
{
    try {
        $absensi = Absensi::all();
        return response()->json($absensi, 200);
    } catch (\Exception $e) {
        Log::error('Error fetching absensi: ' . $e->getMessage());
        return response()->json(['message' => 'Error fetching absensi'], 500);
    }
}

public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'email' => 'required|email',
            'login_time' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $absensi = new Absensi();
        $absensi->email = $validated['email'];
        $absensi->login_time = $validated['login_time'];
        $absensi->save();

        return response()->json(['message' => 'Absensi berhasil disimpan'], 201);
    } catch (\Exception $e) {
        Log::error('Error saving absensi: ' . $e->getMessage());
        return response()->json(['message' => 'Error saving absensi'], 500);
    }
}

public function destroy($id)
{
    try {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return response()->json(['message' => 'Absensi deleted successfully'], 200);
    } catch (\Exception $e) {
        Log::error('Gagal deleting absensi: ' . $e->getMessage());
        return response()->json(['message' => 'Gagal deleting absensi'], 500);
    }
}

}
