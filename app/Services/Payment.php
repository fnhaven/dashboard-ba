<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class Payment extends Facade
{
    /**
     * Get a schema builder instance for the default connection.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'App\Services\Payment\Payment';
    }
}