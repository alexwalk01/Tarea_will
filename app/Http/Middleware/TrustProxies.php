<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array|string
     */
    protected $proxies = '*';  // Cambia esto si solo confías en ciertos proxies

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int|string
     */
    protected $headers = [
        'X-Forwarded-For', 'X-Forwarded-Proto', 'X-Forwarded-Port'
    ];
}
