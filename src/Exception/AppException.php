<?php

namespace App\Exception;

use Exception;

class AppException extends Exception
{
    protected $message = 'An error occurred in the application';
}
