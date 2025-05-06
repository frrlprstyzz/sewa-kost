<?php

// app/Http/Controllers/PengaduanController.php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index()
    {
        return Pengaduan::with(['user', 'kosan'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kosan_id' => 'required|exists:kosans,id',
            'isi_pengaduan' => 'required|string',
            'status' => 'in:menunggu,diproses,selesai',
        ]);

        return Pengaduan::create($request->all());
    }

    public function show($id)
    {
        return Pengaduan::with(['user', 'kosan'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $request->validate([
            'isi_pengaduan' => 'sometimes|string',
            'status' => 'in:menunggu,diproses,selesai',
        ]);

        $pengaduan->update($request->all());

        return $pengaduan;
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->delete();

        return response()->json(['message' => 'Pengaduan deleted']);
    }
}
