<?php

namespace iutnc\deefy\renderer;

use iutnc\deefy\dbclasses\User;

class UserRenderer implements Renderer
{
    private User $user;

    public static function roleToString(int $role) : string {
        return match ($role) {
            User::$ROLE_USER => "Basic",
            User::$ROLE_ADMIN => "Admin",
            User::$ROLE_SUPERADMIN => "Super Admin",
            default => "Inconnu"
        };
    }

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function render(): string
    {
        $role = self::roleToString($this->user->role);
        return <<<HTML
<p class="user">{$this->user->email}, {$role}</p>
HTML;

    }
}