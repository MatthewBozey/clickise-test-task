<?php

namespace App\Facades;

use App\Http\Responses\ApiSuccessResponse;
use Illuminate\Support\Facades\Facade;

class ApiSuccess extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'api.success';
    }

    public static function withData($data, $code = 200, $metadata = [], $headers = []): ApiSuccessResponse
    {
        return ApiSuccess::withData($data, $code, $metadata, $headers);
    }
}
