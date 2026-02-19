<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
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
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $regions = Region::all();
        $businessTypes = Shop::getBusinessTypes();
        return view('auth.register', compact('regions', 'businessTypes'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegistrationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            // --- Section: Database Transaction ---
            // Menggunakan transaksi untuk memastikan Data User dan Toko tersimpan bersamaan atau tidak sama sekali (Atomicity)
            DB::beginTransaction();

            // --- Section: Simpan Data User ---
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

            // --- Section: Proses Data Izin Usaha ---
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



            // --- Section: Simpan Data Toko ---
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

            // --- Section: Post-Registration Jobs ---
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
