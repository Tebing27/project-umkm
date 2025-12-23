<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
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
        return view('auth.register');
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
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'string', 'max:20'],
            'place_of_birth' => ['required', 'string', 'max:100'],
            'date_of_birth' => ['required', 'date'],
            'domicile_address' => ['required', 'string'],
            'domicile_rt' => ['nullable', 'string', 'max:5'],
            'domicile_rw' => ['nullable', 'string', 'max:5'],

            // Data Toko (Usaha)
            'shop_name' => ['required', 'string', 'max:255'],
            'product_type' => ['required', 'string', 'max:255'],
            'business_type' => ['required', 'string', 'max:255'],
            'shop_address' => ['required', 'string'],
            'shop_rt' => ['nullable', 'string', 'max:5'],
            'shop_rw' => ['nullable', 'string', 'max:5'],
            
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
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'email' => ':attribute harus berupa email yang valid.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'unique' => ':attribute sudah terdaftar.',
            'confirmed' => 'Konfirmasi :attribute tidak cocok.',
            'date' => ':attribute bukan tanggal yang valid.',
            'url' => ':attribute harus berupa URL yang valid (awali dengan http:// atau https://).',
        ], [
            // Custom Attribute Names
            'name' => 'Nama Pemilik',
            'email' => 'Email',
            'password' => 'Kata Sandi',
            'phone_number' => 'Nomor Handphone',
            'place_of_birth' => 'Tempat Lahir',
            'date_of_birth' => 'Tanggal Lahir',
            'domicile_address' => 'Alamat Domisili',
            'shop_name' => 'Nama Usaha',
            'product_type' => 'Jenis Produk',
            'business_type' => 'Jenis Usaha',
            'shop_address' => 'Alamat Usaha',
        ]);

        try {
            DB::beginTransaction();

            // 2. Simpan Data User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'users', // Default role
                'phone_number' => $request->phone_number,
                'place_of_birth' => $request->place_of_birth,
                'date_of_birth' => $request->date_of_birth,
                'domicile_address' => $request->domicile_address,
                'domicile_rt' => $request->domicile_rt,
                'domicile_rw' => $request->domicile_rw,
            ]);

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
            Shop::create([
                'user_id' => $user->id,
                'name' => $request->shop_name,
                'product_type' => $request->product_type,
                'business_type' => $request->business_type,
                'address' => $request->shop_address,
                'rt' => $request->shop_rt,
                'rw' => $request->shop_rw,
                'licenses' => !empty($licenses) ? $licenses : null, // Simpan sebagai JSON
                'social_instagram' => $request->social_instagram,
                'social_tiktok' => $request->social_tiktok,
                'social_facebook' => $request->social_facebook,
                'social_website' => $request->social_website,
            ]);

            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));

        } catch (\Exception $e) {
            DB::rollBack();
            // Log error jika perlu: \Log::error($e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi. ' . $e->getMessage()])->withInput();
        }
    }
}
