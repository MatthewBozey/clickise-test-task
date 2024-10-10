<?php

namespace App\Service;

use App\Http\Responses\ApiSuccessResponse;
use Illuminate\Http\Request;

abstract class BaseService
{
    protected $model;

    public function get(Request $request): ApiSuccessResponse
    {
        return new ApiSuccessResponse($this->model::orderBy('id', 'desc')->get());
    }

    public function store($request): ApiSuccessResponse
    {
        return new ApiSuccessResponse($this->model::create($request->validated()));
    }

    public function show(Request $request): ApiSuccessResponse
    {
        return new ApiSuccessResponse($this->model::findOrFail($request->route('id')));
    }

    /**
     * @param  mixed  $request
     */
    public function update($request): ApiSuccessResponse
    {
        $item = $this->model::findOrFail($request->route('id'));
        $item->update($request->validated());

        return new ApiSuccessResponse($item);
    }

    public function destroy(Request $request): ApiSuccessResponse
    {
        $item = $this->model::findOrFail($request->route('id'));
        $item->delete();

        return new ApiSuccessResponse($item);
    }
}
