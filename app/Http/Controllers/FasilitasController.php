<?php

// app/Http/Controllers/FasilitasController.php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function index()
    {
        try {
            $fasilitas = Fasilitas::all();
            return response()->json($fasilitas);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching facilities',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'kosan_id' => 'required|exists:kosans,id',
            'nama_fasilitas' => 'required|string|max:255',
        ]);

        return Fasilitas::create($request->all());
    }

    public function show($id)
    {
        return Fasilitas::with('kosan')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        $request->validate([
            'kosan_id' => 'sometimes|exists:kosans,id',
            'nama_fasilitas' => 'sometimes|string|max:255',
        ]);

        $fasilitas->update($request->all());

        return $fasilitas;
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->delete();

        return response()->json(['message' => 'Fasilitas deleted']);
    }
}
