<?php

namespace App\Exception;

class InvalidSearchQueryException extends AppException
{
    protected $message = 'The search query provided is invalid';
}
