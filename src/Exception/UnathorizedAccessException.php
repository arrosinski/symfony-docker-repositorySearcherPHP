<?php

namespace App\Exception;

class UnauthorizedAccessException extends AppException
{
    protected $message = 'You do not have permission to access this resource';
}
