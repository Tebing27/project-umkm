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
        
        $totalShops = $shops->count();
        $verifiedShopsCount = $shops->where('is_verified', true)->count();
        $rejectedShopsCount = $shops->where('is_verified', false)->whereNotNull('rejection_reason')->count();
        $pendingShopsCount = $shops->where('is_verified', false)->whereNull('rejection_reason')->count();
        $newShopsThisWeek = $shops->where('created_at', '>=', now()->subWeek())->count();
        
        return view('admin.dashboard.index', compact(
            'shops', 
            'totalShops', 
            'verifiedShopsCount', 
            'pendingShopsCount', 
            'rejectedShopsCount',
            'newShopsThisWeek'
        ));
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
            ->when($request->status === 'verified', function ($q) {
                $q->where('is_verified', true);
            })
            ->when($request->status === 'pending', function ($q) {
                $q->where('is_verified', false)->whereNull('rejection_reason');
            })
            ->when($request->status === 'rejected', function ($q) {
                $q->where('is_verified', false)->whereNotNull('rejection_reason');
            })
            ->latest()
            ->get();


        $tabs = [
            ['id' => 'all', 'label' => 'Semua'],
            ['id' => 'verified', 'label' => 'Terverifikasi'],
            ['id' => 'pending', 'label' => 'Menunggu'],
            ['id' => 'rejected', 'label' => 'Ditolak'],
        ];

        $currentStatus = $request->status ?? 'all';

        return view('admin.users.index', compact('shops', 'search', 'tabs', 'currentStatus'));
    }

    public function userDetail($id)
    {
        $shop = Shop::with('user')->findOrFail($id);
        return view('admin.users.detail.index', compact('shop'));
    }

    public function setting()
    {
        $user = auth()->user();
        return view('admin.settings.index', compact('user'));
    }

    public function verifyShop($id)
    {
        $shop = Shop::findOrFail($id);

        if (!$shop->isComplete()) {
            return redirect()->back()->with('error', 'Data UMKM belum lengkap. Mohon lengkapi nama, deskripsi, alamat, lokasi (peta), wilayah, jenis usaha, omset, upload minimal 1 produk, dan upload visualisasi foto sebelum verifikasi.');
        }

        $shop->is_verified = true;
        $shop->rejection_reason = null;
        $shop->save();

        \App\Events\ShopUpdated::dispatch($shop->id);
        
        return redirect()->back()->with('success', 'UMKM telah berhasil diverifikasi.');
    }

    public function rejectShop(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $shop = Shop::findOrFail($id);
        $shop->is_verified = false;
        $shop->rejection_reason = $request->reason;
        $shop->save();

        \App\Events\ShopUpdated::dispatch($shop->id);

        return redirect()->back()->with('success', 'UMKM telah ditolak dengan alasan yang diberikan.');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        \App\Events\UserUpdated::dispatch($user->id, 'profile_update');

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user = auth()->user();

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        \App\Events\SettingsUpdated::dispatch('password');

        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
}
