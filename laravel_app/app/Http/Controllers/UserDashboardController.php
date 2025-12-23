<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $shop = $user->shop;
        return view('users.index', compact('shop'));
    }

    public function detailLokasi()
    {
        $user = Auth::user();
        $shop = $user->shop;
        return view('users.lokasi', compact('shop'));
    }



    public function storeLokasi(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $shop = $user->shop;

        $shop->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->back()->with('success', 'Titik lokasi berhasil disimpan.');
    }

    public function toko()
    {
        return view('users.toko');
    }

    public function editToko()
    {
        $user = Auth::user();
        $shop = $user->shop;
        return view('users.edit-toko', compact('shop'));
    }

    public function updateToko(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_type' => 'required|string|max:255',
            'business_type' => 'required|string',
            'omset_min' => 'nullable|string',
            'omset_max' => 'nullable|string',
            'address' => 'required|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            // 'logo' => 'nullable|image|max:2048', // Enable if logo column exists
        ]);

        $user = Auth::user();
        $shop = $user->shop;

        // Omset cleanup
        $omset_min = $request->omset_min ? preg_replace('/[^0-9]/', '', $request->omset_min) : null;
        $omset_max = $request->omset_max ? preg_replace('/[^0-9]/', '', $request->omset_max) : null;

        // Licenses JSON Construction
        $licenses = [];
        if($request->license_type && $request->license_number) {
            foreach($request->license_type as $key => $type) {
                if($type && isset($request->license_number[$key])) {
                    $licenses[] = ['type' => $type, 'number' => $request->license_number[$key]];
                }
            }
        }

        $shop->update([
            'name' => $request->shop_name,
            'description' => $request->description,
            'product_type' => $request->product_type,
            'business_type' => $request->business_type,
            'omset_min' => $omset_min,
            'omset_max' => $omset_max,
            'address' => $request->address,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'licenses' => !empty($licenses) ? json_encode($licenses) : null,
            'social_instagram' => $request->social_instagram,
            'social_facebook' => $request->social_facebook,
        ]);

        return redirect()->back()->with('success', 'Informasi toko berhasil diperbarui.');
    }

    public function setting()
    {
        return view('users.setting');
    }

    public function foto()
    {
        return view('users.kelola-foto');
    }
}
