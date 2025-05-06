<?php

// app/Http/Controllers/KosanController.php

namespace App\Http\Controllers;

use App\Models\Kosan;
use Illuminate\Http\Request;

class KosanController extends Controller
{
    public function index()
    {
        return Kosan::with(['user', 'kategori'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_kosan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'deskripsi' => 'nullable|string',
            'jumlah_kamar' => 'required|integer',
            'harga_per_bulan' => 'required|numeric',
            'galeri' => 'nullable|array',
            'galeri.*' => 'url',
        ]);

        return Kosan::create($request->all());
    }

    public function show($id)
    {
        return Kosan::with(['user', 'kategori'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $kosan = Kosan::findOrFail($id);

        $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'kategori_id' => 'sometimes|exists:kategoris,id',
            'nama_kosan' => 'sometimes|string|max:255',
            'alamat' => 'sometimes|string',
            'deskripsi' => 'nullable|string',
            'jumlah_kamar' => 'sometimes|integer',
            'harga_per_bulan' => 'sometimes|numeric',
            'galeri' => 'nullable|array',
            'galeri.*' => 'url',
        ]);

        $kosan->update($request->all());

        return $kosan;
    }

    public function destroy($id)
    {
        $kosan = Kosan::findOrFail($id);
        $kosan->delete();

        return response()->json(['message' => 'Kosan deleted']);
    }
}
