<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OverlaySetting;

class OverlayController extends Controller
{
    public function edit()
    {
        $user    = Auth::user();
        $overlay = OverlaySetting::firstOrCreate(
            ['user_id' => $user->id],
            ['posisi' => 'bottom-left', 'warna' => '#4DC8F0', 'durasi' => 10]
        );

        return view('overlay.edit', compact('user', 'overlay'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'posisi' => 'required|in:top-left,top-right,bottom-left,bottom-right',
            'warna'  => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'durasi' => 'required|integer|min:3|max:60',
        ], [
            'posisi.required' => 'Posisi overlay wajib dipilih.',
            'posisi.in'       => 'Posisi tidak valid.',
            'warna.required'  => 'Warna wajib dipilih.',
            'warna.regex'     => 'Format warna tidak valid.',
            'durasi.required' => 'Durasi wajib diisi.',
            'durasi.min'      => 'Durasi minimal 3 detik.',
            'durasi.max'      => 'Durasi maksimal 60 detik.',
        ]);

        $user = Auth::user();
        OverlaySetting::updateOrCreate(
            ['user_id' => $user->id],
            [
                'posisi' => $request->posisi,
                'warna'  => $request->warna,
                'durasi' => $request->durasi,
            ]
        );

        return back()->with('success', 'Pengaturan overlay berhasil disimpan!');
    }
}
