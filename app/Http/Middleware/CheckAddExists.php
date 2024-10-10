<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiErrorResponse;
use App\Models\Adds;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAddExists
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Adds::whereId($request->route('id'))->doesntExist()) {
            return new ApiErrorResponse('Объявления не найдено', [], Response::HTTP_NOT_FOUND);
        }

        return $next($request);
    }
}
