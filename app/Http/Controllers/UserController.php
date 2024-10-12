<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiSuccessResponse;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends BaseController
{
    public function __construct(UserService $service)
    {
        parent::__construct($service);
    }

    public static function middleware()
    {
        return [
            new Middleware('checkUserExists', only: ['destroy', 'show', 'update']),
        ];
    }

    public function getUserList(Request $request): ApiSuccessResponse
    {
        return $this->service->getUserList();
    }
}
