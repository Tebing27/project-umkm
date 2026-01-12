<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use App\Models\Region;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $regions = Region::all();
        return view('auth.register', compact('regions'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            // Data User (Pemilik)
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()],
            'phone_number' => ['required', 'string', 'max:20'],
            'place_of_birth' => ['required', 'string', 'max:100'],
            'date_of_birth' => ['required', 'date'],
            'domicile_address' => ['required', 'string'],

            // Data Toko (Usaha)
            'shop_name' => ['required', 'string', 'max:255'],
            'product_type' => ['required', 'string', 'max:255'],
            'business_type' => ['required', 'string', 'max:255'],
            'shop_address' => ['required', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'region_id' => ['required', 'exists:regions,id'],
            
            // Izin Usaha (Array)
            'license_type.*' => ['nullable', 'string'],
            'license_number.*' => ['nullable', 'string'],

            // Social Media (Nullable)
            'social_instagram' => ['nullable', 'url'],
            'social_tiktok' => ['nullable', 'url'],
            'social_facebook' => ['nullable', 'url'],
            'social_website' => ['nullable', 'url'],
        ], [
            // Custom Messages (Bahasa Indonesia)
            'required' => translate(':attribute wajib diisi.'),
            'string' => translate(':attribute harus berupa teks.'),
            'numeric' => translate(':attribute harus berupa angka.'),
            'email' => translate(':attribute harus berupa email yang valid.'),
            'max' => translate(':attribute tidak boleh lebih dari :max karakter.'),
            'unique' => translate(':attribute sudah terdaftar.'),
            'confirmed' => translate('Konfirmasi :attribute tidak cocok.'),
            'date' => translate(':attribute bukan tanggal yang valid.'),
            'url' => translate(':attribute harus berupa URL yang valid (awali dengan http:// atau https://).'),
        ], [
            // Custom Attribute Names
            'name' => translate('Nama Pemilik'),
            'email' => translate('Email'),
            'password' => translate('Kata Sandi'),
            'phone_number' => translate('Nomor Handphone'),
            'place_of_birth' => translate('Tempat Lahir'),
            'date_of_birth' => translate('Tanggal Lahir'),
            'domicile_address' => translate('Alamat Domisili'),
            'shop_name' => translate('Nama Usaha'),
            'product_type' => translate('Jenis Produk'),
            'business_type' => translate('Jenis Usaha'),
            'shop_address' => translate('Alamat Usaha'),
            'latitude' => translate('Latitude'),
            'longitude' => translate('Longitude'),
            'region_id' => translate('Wilayah'),
        ]);

        try {
            DB::beginTransaction();

            // 2. Simpan Data User
            $user = new User();
            $user->fill([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'place_of_birth' => $request->place_of_birth,
                'date_of_birth' => $request->date_of_birth,
                'domicile_address' => $request->domicile_address,
            ]);
            $user->password = Hash::make($request->password);
            $user->role = 'users'; // Explicitly assign role
            $user->save();

            // 3. Proses Data Izin Usaha (Gabungkan Type & Number)
            $licenses = [];
            if ($request->has('license_type') && $request->has('license_number')) {
                foreach ($request->license_type as $key => $type) {
                    if (!empty($type) && !empty($request->license_number[$key])) {
                        $licenses[] = [
                            'type' => $type,
                            'number' => $request->license_number[$key],
                        ];
                    }
                }
            }

            // 4. Simpan Data Toko
            $shop = Shop::create([
                'user_id' => $user->id,
                'name' => $request->shop_name,
                'product_type' => $request->product_type,
                'business_type' => $request->business_type,
                'address' => $request->shop_address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'region_id' => $request->region_id,
                'licenses' => !empty($licenses) ? $licenses : null, // Simpan sebagai JSON
                'social_instagram' => $request->social_instagram,
                'social_tiktok' => $request->social_tiktok,
                'social_facebook' => $request->social_facebook,
                'social_website' => $request->social_website,
            ]);

            DB::commit();

            // Dispatch Translation Job after transaction commit
            \App\Jobs\TranslateShopAttributes::dispatch($shop);

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));

        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Registration failed: ' . $e->getMessage());
            return back()->withErrors(['error' => translate('Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')])->withInput();
        }
    }
}
