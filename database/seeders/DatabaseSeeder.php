<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User
        $userId = DB::table('users')->insertGetId([
            'nama'       => 'Naufal Streamer',
            'username'   => 'naufal_streamer',
            'email'      => 'naufal@streamer.com',
            'password'   => Hash::make('password'),
            'bio'        => 'Streamer konten gaming & hiburan. Support terus ya gaes! 🎮',
            'instagram'  => '@naufal_streamer',
            'initials'   => 'NS',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Donasi
        $donations = [
            ['donor_nama' => 'Wahyu',    'donor_initial' => 'W',  'donor_color' => '#4df09e', 'jumlah' => 1000000, 'pesan' => 'Mana MBG nya yang!!!',        'created_at' => '2025-05-01 23:20:00'],
            ['donor_nama' => 'Mas Rass', 'donor_initial' => 'MR', 'donor_color' => '#4DC8F0', 'jumlah' => 1000000, 'pesan' => 'Absen Bang!',                 'created_at' => '2025-05-01 23:18:00'],
            ['donor_nama' => 'Lipp',     'donor_initial' => 'L',  'donor_color' => '#f0d54d', 'jumlah' => 400000,  'pesan' => 'Kapan Dramanya Kang',         'created_at' => '2025-05-01 22:20:00'],
            ['donor_nama' => 'PAL',      'donor_initial' => 'P',  'donor_color' => '#f0914d', 'jumlah' => 50000,   'pesan' => 'Semangat streamnya kang!',    'created_at' => '2025-05-01 21:20:00'],
            ['donor_nama' => 'Daniel',   'donor_initial' => 'D',  'donor_color' => '#4DC8F0', 'jumlah' => 100000,  'pesan' => 'Keep up the great streams!',  'created_at' => '2025-05-01 20:00:00'],
            ['donor_nama' => 'Rasya',    'donor_initial' => 'R',  'donor_color' => '#f0914d', 'jumlah' => 50000,   'pesan' => 'Terus semangat bang!',        'created_at' => '2025-05-01 19:00:00'],
        ];

        foreach ($donations as $d) {
            DB::table('donasi')->insert(array_merge($d, [
                'user_id'    => $userId,
                'updated_at' => $d['created_at'],
            ]));
        }

        // Overlay
        DB::table('overlay_settings')->insert([
            'user_id'    => $userId,
            'posisi'     => 'bottom-left',
            'warna'      => '#4DC8F0',
            'durasi'     => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
