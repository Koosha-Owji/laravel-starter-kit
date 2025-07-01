<?php

namespace App\Auth;

use App\Models\User;
use App\Services\KindeService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * KindeGuard - Custom authentication guard using Kinde
 *
 * This guard integrates Kinde authentication with Laravel's auth system.
 * It makes Auth::check() and Auth::user() work with Kinde as the source of truth.
 */
class KindeGuard implements Guard
{
    protected KindeService $kindeService;
    protected ?Authenticatable $user = null;

    public function __construct(KindeService $kindeService)
    {
        $this->kindeService = $kindeService;
    }

    /**
     * Determine if the current user is authenticated.
     */
    public function check(): bool
    {
        return $this->kindeService->isAuthenticated();
    }

    /**
     * Determine if the current user is a guest.
     */
    public function guest(): bool
    {
        return !$this->check();
    }

    /**
     * Get the currently authenticated user.
     */
    public function user(): ?Authenticatable
    {
        if ($this->user) {
            return $this->user;
        }

        if ($this->check()) {
            $kindeUserData = $this->kindeService->getUser();
            if ($kindeUserData) {
                $this->user = new User((array) $kindeUserData);
                return $this->user;
            }
        }

        return null;
    }

    public function id()
    {
        return $this->user()?->getAuthIdentifier();
    }

    public function validate(array $credentials = []): bool
    {
        return false; // Not used with Kinde
    }

    public function hasUser(): bool
    {
        return $this->user !== null;
    }

    public function setUser(Authenticatable $user): void
    {
        $this->user = $user;
    }
}