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
            'durasi_sewa' => 'required|integer|min:1|max:24',
            'total_harga' => 'required|numeric',
            'status' => 'in:pending,diterima,ditolak',
            'bukti_pembayaran' => 'required|image|max:2048',
            'kode_pembayaran' => 'required|string|max:10', // tambahkan validasi ini
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

    public function getUserPayments($userId)
    {
        try {
            $payments = Pembayaran::with(['kosan'])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $payments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error fetching payments: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAcceptedPaymentsByKosanOwner($userId)
    {
        try {
            $payments = Pembayaran::with(['user', 'kosan'])
                ->whereHas('kosan', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->where('status', 'diterima')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $payments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error fetching payments: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cancel($id, Request $request)
    {
        $user = $request->user();
        $pembayaran = Pembayaran::findOrFail($id);

        // Pastikan hanya user yang punya pembayaran ini yang bisa membatalkan
        if ($pembayaran->user_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak diizinkan membatalkan pesanan ini'
            ], 403);
        }

        // Hanya bisa membatalkan jika status masih pending
        if ($pembayaran->status !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan tidak bisa dibatalkan'
            ], 400);
        }

        $pembayaran->status = 'dibatalkan'; // Ubah dari 'ditolak' ke 'dibatalkan'
        $pembayaran->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan berhasil dibatalkan'
        ]);
    }
}
