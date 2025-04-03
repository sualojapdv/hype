<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',
        'digitopay/*',
        'slotegrator/*',
        'suitpay/*',
        'vgames/*',
        'webhooks/*',
        'salsa/*',
        'gitslotpark/*',
        'fivers/*',
        'bspay/*',
        'gold_api',
        'gold_api/game_callback',
        'gold_api/user_balance',
        'gold_api/money_callback',
        'gold_api/*',
        'kagaming/*',
        'vibra/*',
        'cron/*',
        'venix_api',
        'venix_api/*',
        'ever/*',
        'ever',
        'playgaming',
        'playgaming/*',
        'playigaming_api',
        'playigaming_api/*',
        'playfiver/*',
        'mercadopago/*',
        'mercadopago',
        'callback',
		'callback/*',
    ];
}
