<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case MANAGE_USERS            = 'manage users';
    case MANAGE_ANIMALS          = 'manage animals';
    case MANAGE_SHELTERS         = 'manage shelters';
    case MANAGE_DONATION_CATALOG = 'manage donation_catalog';
    case REVIEW_APPLICATIONS     = 'review applications';
}