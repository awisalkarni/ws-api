<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegisterForm(): View
    {
        return view('consumer.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt(bin2hex(random_bytes(16))),
            'api_key' => User::generateApiKey(),
        ]);

        Auth::guard('web')->login($user);

        return redirect()->route('consumer.dashboard')
            ->with('api_key', $user->api_key);
    }

    public function showLoginForm(): View
    {
        return view('consumer.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'api_key' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])
            ->where('api_key', $credentials['api_key'])
            ->first();

        if (! $user) {
            return back()
                ->withErrors(['email' => 'Invalid email or API key.'])
                ->onlyInput('email');
        }

        Auth::guard('web')->login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('consumer.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('consumer.login');
    }
}
