<?php

namespace App\Exception;

class ResourceNotFoundException extends AppException
{
    protected $message = 'The requested resource was not found';
}
