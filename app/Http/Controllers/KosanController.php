<?php

namespace App\Http\Controllers;

use App\Models\Kosan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class KosanController extends Controller
{
    public function index()
    {
        $kosans = Kosan::with(['user', 'kategori'])->get();
        return response()->json(['data' => $kosans], 200);
    }

    public function store(Request $request)
    {
        try {
            // Validasi data input
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'kategori_id' => 'required|exists:kategoris,id',
                'nama_kosan' => 'required|string|max:255',
                'alamat' => 'required|string',
                'deskripsi' => 'nullable|string',
                'jumlah_kamar' => 'required|integer',
                'harga_per_bulan' => 'required|numeric',
                'galeri' => 'nullable|array',
                'galeri.*' => 'file|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Menyimpan gambar galeri jika ada
            $paths = [];
            if ($request->hasFile('galeri')) {
                foreach ($request->file('galeri') as $file) {
                    $paths[] = $file->store('galeri', 'public');
                }
            }

            // Menyimpan data kosan
            $kosan = Kosan::create([
                'user_id' => $validated['user_id'],
                'kategori_id' => $validated['kategori_id'],
                'nama_kosan' => $validated['nama_kosan'],
                'alamat' => $validated['alamat'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'jumlah_kamar' => $validated['jumlah_kamar'],
                'harga_per_bulan' => $validated['harga_per_bulan'],
                'galeri' => json_encode($paths),
            ]);

            return response()->json($kosan, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->errors(),
            ], 422);
        }
    }

    public function show($id)
    {
        return Kosan::with(['user', 'kategori'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $kosan = Kosan::findOrFail($id);

        // Validasi data input
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'kategori_id' => 'sometimes|exists:kategoris,id',
            'nama_kosan' => 'sometimes|string|max:255',
            'alamat' => 'sometimes|string',
            'deskripsi' => 'nullable|string',
            'jumlah_kamar' => 'sometimes|integer',
            'harga_per_bulan' => 'sometimes|numeric',
            'galeri' => 'nullable|array',
            'galeri.*' => 'file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $validated;

        // Menyimpan gambar galeri jika ada
        if ($request->hasFile('galeri')) {
            $paths = [];
            foreach ($request->file('galeri') as $file) {
                $paths[] = $file->store('galeri', 'public');
            }
            $data['galeri'] = json_encode($paths);
        }

        $kosan->update($data);

        return response()->json($kosan);
    }

    public function destroy($id)
    {
        $kosan = Kosan::findOrFail($id);
        $kosan->delete();

        return response()->json(['message' => 'Kosan deleted']);
    }
}
