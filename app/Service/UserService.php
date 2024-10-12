<?php

namespace App\Service;

use App\Facades\ApiSuccess;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\User;

class UserService extends BaseService
{
    public function __construct()
    {
        $this->model = User::class;
        $this->storeRequest = CreateUserRequest::class;
        $this->updateRequest = UpdateUserRequest::class;
        $this->relations = ['companies'];
    }

    public function getUserList(): ApiSuccessResponse
    {
        return ApiSuccess::withData(User::orderBy('name')->get(['id', 'name']));
    }
}
