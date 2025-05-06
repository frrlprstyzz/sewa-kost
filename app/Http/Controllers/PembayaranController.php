<?php

// app/Http/Controllers/PembayaranController.php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index()
    {
        return Pembayaran::with(['user', 'kosan'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kosan_id' => 'required|exists:kosans,id',
            'tanggal_bayar' => 'required|date',
            'status' => 'in:pending,diterima,ditolak',
            'bukti_pembayaran' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('bukti_pembayaran')) {
            $data['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        return Pembayaran::create($data);
    }

    public function show($id)
    {
        return Pembayaran::with(['user', 'kosan'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $request->validate([
            'tanggal_bayar' => 'sometimes|date',
            'status' => 'in:pending,diterima,ditolak',
            'bukti_pembayaran' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('bukti_pembayaran')) {
            if ($pembayaran->bukti_pembayaran) {
                Storage::disk('public')->delete($pembayaran->bukti_pembayaran);
            }
            $data['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $pembayaran->update($data);

        return $pembayaran;
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if ($pembayaran->bukti_pembayaran) {
            Storage::disk('public')->delete($pembayaran->bukti_pembayaran);
        }

        $pembayaran->delete();

        return response()->json(['message' => 'Pembayaran deleted']);
    }
}
