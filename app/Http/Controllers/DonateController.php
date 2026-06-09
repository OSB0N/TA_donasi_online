<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donasi;
use App\Helpers\Rupiah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonateController extends Controller
{
    /**
     * Halaman donate — hanya untuk user yang sudah login
     * Mengirim donasi ke streamer berdasarkan username mereka sendiri
     */
    public function show()
    {
        $user     = Auth::user();
        $riwayat  = Donasi::where('user_id', $user->id)
                        ->orderByDesc('created_at')
                        ->limit(10)
                        ->get();

        return view('donate.show', compact('user', 'riwayat'));
    }

    /**
     * Proses donasi yang masuk (dari penonton ke streamer)
     */
    public function send(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'donor_nama' => 'required|string|max:60',
            'jumlah'     => 'required|numeric|min:1000|max:10000000',
            'pesan'      => 'nullable|string|max:300',
        ], [
            'donor_nama.required' => 'Nama donatur wajib diisi.',
            'donor_nama.max'      => 'Nama maksimal 60 karakter.',
            'jumlah.required'     => 'Nominal donasi wajib diisi.',
            'jumlah.numeric'      => 'Nominal harus berupa angka.',
            'jumlah.min'          => 'Minimal donasi Rp 1.000.',
            'jumlah.max'          => 'Maksimal donasi Rp 10.000.000.',
            'pesan.max'           => 'Pesan maksimal 300 karakter.',
        ]);

        // Generate initials & color untuk donor
        $words    = explode(' ', trim($request->donor_nama));
        $initials = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(mb_substr($word, 0, 1));
        }
        $initials = $initials ?: 'A';

        $colors = ['#4DC8F0', '#4ade80', '#f0d54d', '#f0914d', '#a855f7', '#ec4899'];
        $color  = $colors[abs(crc32($request->donor_nama)) % count($colors)];

        Donasi::create([
            'user_id'       => $user->id,
            'donor_nama'    => $request->donor_nama,
            'donor_initial' => $initials,
            'donor_color'   => $color,
            'jumlah'        => (int) $request->jumlah,
            'pesan'         => $request->pesan,
        ]);

        return redirect()
            ->route('donate.show')
            ->with('donate_success', true)
            ->with('donate_amount', Rupiah::format($request->jumlah))
            ->with('donate_nama', $request->donor_nama);
    }
}
