<?php

namespace App\Http\Controllers;

use App\Service\AddsService;
use Illuminate\Routing\Controllers\Middleware;

class AddsController extends BaseController
{
    public function __construct(AddsService $service)
    {
        parent::__construct($service);
    }

    public static function middleware()
    {
        return [
            new Middleware('checkAddExists', only: ['destroy', 'show', 'update']),
        ];
    }
}
