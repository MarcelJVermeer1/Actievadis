<?php

namespace App;

enum EnrollmentVisibility: string
{
    case Full = 'iedereen';
    case User = 'alleen gebruikers en beheerders';
    case Admin = 'alleen beheerders';
}
