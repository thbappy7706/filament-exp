<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    public function getHeading(): string
    {
        return 'Admin Login';
    }

    public function getSubheading(): ?string
    {
        return 'Please sign in to continue';
    }
}
