<?php

namespace App\Service;

use App\Facades\ApiSuccess;
use App\Http\Responses\ApiSuccessResponse;
use Illuminate\Http\Request;

abstract class BaseService
{
    protected $model;

    public function get(Request $request): ApiSuccessResponse
    {
        return ApiSuccess::withData($this->model::orderBy('id', 'desc')->get());
    }

    public function store($request): ApiSuccessResponse
    {
        return ApiSuccess::withData($this->model::create($request->validated()));
    }

    public function show(Request $request): ApiSuccessResponse
    {
        return ApiSuccess::withData($this->model::findOrFail($request->route('id')));
    }

    /**
     * @param  mixed  $request
     */
    public function update($request): ApiSuccessResponse
    {
        $item = $this->model::findOrFail($request->route('id'));
        $item->update($request->validated());

        return ApiSuccess::withData($item);
    }

    public function destroy(Request $request): ApiSuccessResponse
    {
        $item = $this->model::findOrFail($request->route('id'));
        $item->delete();

        return ApiSuccess::withData($item);
    }
}
