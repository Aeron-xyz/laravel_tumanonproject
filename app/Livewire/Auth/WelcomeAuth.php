<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;

class WelcomeAuth extends Component
{
    public bool $isLogin = true;

    // Login fields
    public string $loginEmail = '';

    public string $loginPassword = '';

    public bool $remember = false;

    // Register fields
    public string $name = '';

    public string $registerEmail = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function toggleMode(): void
    {
        $this->isLogin = !$this->isLogin;
        $this->resetValidation();
        $this->reset(['loginEmail', 'loginPassword', 'name', 'registerEmail', 'password', 'password_confirmation', 'remember']);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login()
    {
        $this->validate([
            'loginEmail' => ['required', 'string', 'email'],
            'loginPassword' => ['required', 'string'],
        ]);

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->loginEmail, 'password' => $this->loginPassword], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'loginEmail' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        // Clear sensitive data before redirect
        $this->reset(['loginEmail', 'loginPassword', 'remember']);

        // Use standard Laravel redirect to avoid Livewire state in URL
        return Redirect::intended(route('dashboard'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function register()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'registerEmail' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['email'] = $validated['registerEmail'];
        unset($validated['registerEmail']);
        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        // Clear sensitive data before redirect
        $this->reset(['name', 'registerEmail', 'password', 'password_confirmation']);

        // Use standard Laravel redirect to avoid Livewire state in URL
        return Redirect::route('dashboard');
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'loginEmail' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->loginEmail).'|'.request()->ip());
    }

    public function render()
    {
        return view('livewire.auth.welcome-auth');
    }
}

