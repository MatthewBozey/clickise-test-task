<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiSuccessResponse;
use App\Service\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

abstract class BaseController extends Controller implements HasMiddleware
{
    protected $service;

    public function __construct(BaseService $service)
    {
        $this->service = $service;
    }

    public static function middleware()
    {
        return [
            new Middleware('checkExists', only: ['destroy', 'show', 'update']),
        ];
    }

    public function index(Request $request): ApiSuccessResponse
    {
        return $this->service->get($request);
    }

    public function show(Request $request)
    {
        return $this->service->show($request);
    }

    public function destroy(Request $request)
    {
        return $this->service->destroy($request);
    }

    /**
     * @throws BindingResolutionException
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @throws BindingResolutionException
     */
    public function update(Request $request)
    {
        return $this->service->update($request);
    }
}
