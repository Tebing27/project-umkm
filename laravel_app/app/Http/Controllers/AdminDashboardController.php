<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Stats only for main dashboard
        $shops = Shop::all(); 
        return view('admin.dashboard', compact('shops'));
    }

    public function users(Request $request)
    {
        // List all shops / users
        // Simple search filter
        $search = $request->input('search');
        $shops = Shop::with('user')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhereHas('user', function ($q) use ($search) {
                                 $q->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                             });
            })
            ->latest()
            ->get();

        return view('admin.users', compact('shops', 'search'));
    }

    public function userDetail($id)
    {
        $shop = Shop::with('user')->findOrFail($id);
        return view('admin.users.detail', compact('shop'));
    }

    public function setting()
    {
        return view('admin.setting');
    }

    public function verifyShop($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->update([
            'is_verified' => true,
            'rejection_reason' => null
        ]);
        
        return redirect()->back()->with('success', 'UMKM telah berhasil diverifikasi.');
    }

    public function rejectShop(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $shop = Shop::findOrFail($id);
        $shop->update([
            'is_verified' => false,
            'rejection_reason' => $request->reason
        ]);

        return redirect()->back()->with('success', 'UMKM telah ditolak dengan alasan yang diberikan.');
    }
}
