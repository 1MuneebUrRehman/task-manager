<?php

namespace App\Enums;

enum RolesNameEnum: string
{
    case Admin = 'admin';
    case Manager = 'manager';
    case User = 'user';
}
