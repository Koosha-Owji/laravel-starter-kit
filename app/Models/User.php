<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * KindeUser - Represents a user from Kinde without database storage
 *
 * This class extends Laravel's base User class to work with
 * Laravel's auth system while using Kinde as the source of truth.
 */
class User extends Authenticatable
{
    protected $table = null; // No database table needed

    public function __construct(array $attributes = [])
    {
        parent::__construct();
        $this->setRawAttributes($attributes);
    }

    public function getAuthIdentifier()
    {
        return $this->getAttribute('id');
    }

    public function getAuthPasswordName(): string
    {
        return 'password'; // Required by Authenticatable interface, but not used with Kinde
    }
}
