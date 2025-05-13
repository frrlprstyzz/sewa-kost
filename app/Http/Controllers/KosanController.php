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
        $kosans = Kosan::with(['user', 'kategori', 'fasilitas'])->get();
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
                'galeri.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'fasilitas' => 'nullable|array',
                'fasilitas.*' => 'exists:fasilitas,id',
            ]);

            $images = [];
            if ($request->hasFile('galeri')) {
                foreach ($request->file('galeri') as $image) {
                    $path = $image->store('kosans', 'public');
                    $images[] = $path;
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
                'galeri' => $images,
            ]);

            // Attach facilities if provided
            if (isset($validated['fasilitas'])) {
                $kosan->fasilitas()->attach($validated['fasilitas']);
            }

            return response()->json([
                'data' => $kosan->load(['kategori', 'fasilitas']),
                'message' => 'Kosan created successfully'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating kosan',
                'error' => $e->getMessage()
            ], 500);
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

    public function getByOwnerId($userId)
    {
        try {
            $kosans = Kosan::with(['kategori', 'fasilitas', 'user'])
                ->where('user_id', $userId)
                ->get();

            return response()->json([
                'data' => $kosans,
                'message' => 'Success fetching kosan data'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching kosan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllPublic()
    {
        try {
            $kosans = Kosan::with(['kategori:id,nama_kategori', 'fasilitas:id,nama_fasilitas'])
                ->select('id', 'nama_kosan', 'alamat', 'harga_per_bulan', 'galeri')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $kosans
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan dalam mengambil data kosan'
            ], 500);
        }
    }

    public function getPublicById($id)
    {
        try {
            $kosan = Kosan::with(['kategori', 'fasilitas', 'user'])
                ->where('id', $id)
                ->get();

            if ($kosan->isEmpty()) {
                return response()->json([
                    'message' => 'Kosan tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'data' => $kosan,
                'message' => 'Success fetching kosan data'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching kosan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
