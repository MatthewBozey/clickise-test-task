<?php

namespace App\Http\Controllers;

use App\Http\Requests\Adds\CreateAddsRequest;
use App\Http\Requests\Adds\UpdateAddsRequest;
use App\Http\Responses\ApiSuccessResponse;
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

    public function store(CreateAddsRequest $request): ApiSuccessResponse
    {
        return $this->service->store($request);
    }

    public function update(UpdateAddsRequest $request, $id): ApiSuccessResponse
    {
        return $this->service->update($request);
    }
}
