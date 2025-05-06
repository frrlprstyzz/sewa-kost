<?php

// app/Http/Controllers/KategoriController.php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return Kategori::with('kosans')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        return Kategori::create($request->all());
    }

    public function show($id)
    {
        return Kategori::with('kosans')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'sometimes|string|max:255',
        ]);

        $kategori->update($request->all());

        return $kategori;
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return response()->json(['message' => 'Kategori deleted']);
    }
}
