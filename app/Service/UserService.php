<?php

namespace App\Service;

use App\Http\Responses\ApiSuccessResponse;
use App\Models\User;

class UserService extends BaseService
{
    public function __construct()
    {
        $this->model = User::class;
    }

    public function get($request): ApiSuccessResponse
    {
        return new ApiSuccessResponse(User::orderBy('id', 'desc')->with(['companies'])->get());
    }

    public function update($request): ApiSuccessResponse
    {
        return parent::update($request);
    }

    public function getUserList(): ApiSuccessResponse
    {
        return new ApiSuccessResponse(User::orderBy('name')->get(['id', 'name']));
    }
}
