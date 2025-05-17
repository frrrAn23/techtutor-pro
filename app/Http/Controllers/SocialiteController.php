<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\Role;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SocialiteController extends Controller
{

    ########################## GOOGLE LOGIN & REGISTRASI ###############################
        public function redirectToGoogleLogin()
    {
        session(['auth_mode' => 'login']);
        return Socialite::driver('google')->redirect();
    }

    public function redirectToGoogleRegister()
    {
        session(['auth_mode' => 'register']);
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google.');
        }

        $authMode = session('auth_mode');
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($authMode === 'login') {
            // Jika user TIDAK ADA, tolak login
            if (!$existingUser) {
                return redirect()->route('login')->with('error', 'Akun Google kamu tidak ditemukan. Silakan registrasi terlebih dahulu.');
            }

            Auth::login($existingUser, true);
            return redirect()->route('dashboard.index');

        } elseif ($authMode === 'register') {
            // Jika user SUDAH ADA, tolak register
            if ($existingUser) {
                return redirect()->route('login')->with('error', 'Akun Google kamu sudah terdaftar. Silakan login.');
            }

            // Buat akun baru
            $studentRole = Role::where('name', RoleEnum::STUDENT)->first();
            $username = $this->makeUniqueUsername(explode('@', $googleUser->getEmail())[0]);

            $newUser = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'username' => $username,
                'password' => bcrypt(Str::random(16)),
                'email_verified_at' => now(),
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'role_id' => $studentRole->id,
            ]);

            Auth::login($newUser, true);
            return redirect()->route('dashboard.index')->with('success', 'Registrasi dan Login berhasil menggunakan akun Google.');
        }

        return redirect()->route('login')->with('error', 'Mode autentikasi tidak valid.');
    }

    /**
     * Membuat username yang unik dengan menambahkan angka jika perlu
     */
    private function makeUniqueUsername($username)
    {
        $originalUsername = $username;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        return $username;
    }

    ########################## GITHUB LOGIN & REGISTRASI ###############################
    public function redirectToGithubLogin()
    {
        session(['login_action' => 'login']);
        return Socialite::driver('github')->redirect();
    }

    // Redirect ke GitHub (untuk registrasi)
    public function redirectToGithubRegister()
    {
        session(['login_action' => 'register']);
        return Socialite::driver('github')->redirect();
    }

    // Callback setelah GitHub login
    public function handleGithubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['github' => 'Gagal login menggunakan GitHub.']);
        }

        $loginAction = session('login_action');
        $email = $githubUser->getEmail();

        if (!$email) {
            return redirect()->route('login')->withErrors([
                'email' => 'GitHub tidak memberikan akses ke email Anda.'
            ]);
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            // Cek jika user sudah terdaftar tapi menekan tombol register
            if ($loginAction === 'register') {
            return redirect()->route('login')
                ->with('error', 'Akun GitHub kamu sudah terdaftar. Silakan login.');
             }
            

            Auth::login($user);
            return redirect()->route('dashboard.index')->with('success', 'Login berhasil menggunakan akun GitHub yang sudah terdaftar.');
        }

        // Jika user belum terdaftar dan memilih login
        if ($loginAction === 'login') {
            return redirect()->route('login')->with('error', 'Akun GitHub kamu belum terdaftar. Silakan registrasi terlebih dahulu.');
        }

        // Proses registrasi
        $username = Str::slug($githubUser->getNickname() ?? $githubUser->getName());
        $studentRole = Role::where('name', 'student')->first();

        $newUser = User::create([
            'name'              => $githubUser->getName() ?? $githubUser->getNickname(),
            'email'             => $email,
            'username'          => $username,
            'password'          => bcrypt(Str::random(16)),
            'email_verified_at' => now(),
            'provider'          => 'github',
            'provider_id'       => $githubUser->getId(),
            'avatar'            => $githubUser->getAvatar(),
            'role_id'           => $studentRole->id,
        ]);

        Auth::login($newUser);
        return redirect()->route('dashboard.index')->with('success', 'Registrasi dan login berhasil menggunakan akun GitHub.');
    }


    ########################## FACEBOOK LOGIN & REGISTRASI ###############################


}