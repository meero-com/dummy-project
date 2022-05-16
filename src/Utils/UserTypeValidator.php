<?php

declare(strict_types=1);

namespace App\Utils;

class UserTypeValidator
{
    protected const TYPE_SUBSCRIBER = 'subscriber';
    protected const TYPE_CONTRIBUTOR = 'contributor';
    protected const TYPE_AUTHOR = 'author';
    protected const TYPE_EDITOR = 'editor';
    protected const TYPE_ADMINISTRATOR = 'administrator';
    protected const TYPE_SUPER_ADMIN = 'super_admin';

    public const USER_TYPES_ALLOWED = [
        self::TYPE_SUBSCRIBER => 'Type Subscriber',
        self::TYPE_CONTRIBUTOR => 'Type Contributor',
        self::TYPE_AUTHOR => 'Type Author',
        self::TYPE_EDITOR => 'Type Editor',
        self::TYPE_ADMINISTRATOR => 'Type Administrator',
        self::TYPE_SUPER_ADMIN => 'Type Super Admin',
    ];

    public function validateUserType(string $userType): ?bool
    {
        $allowedTypes = [];

        foreach (self::USER_TYPES_ALLOWED as $key => $typeAllowed) {
            $allowedTypes[] = $key;
        }

        if (in_array($userType, $allowedTypes, true)) {
            return true;
        } elseif (!in_array($userType, $allowedTypes, true)) {
            return false;
        } else {
            return null;
        }
    }
}
