<?php

namespace App\Service;

use App\Facades\ApiSuccess;
use App\Http\Requests\Adds\CreateAddsRequest;
use App\Http\Requests\Adds\UpdateAddsRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\Adds;
use Illuminate\Http\Request;

class AddsService extends BaseService
{
    public function __construct()
    {
        $this->model = Adds::class;
        $this->storeRequest = CreateAddsRequest::class;
        $this->updateRequest = UpdateAddsRequest::class;
        $this->relations = ['company'];
    }

    public function get(Request $request): ApiSuccessResponse
    {
        return ApiSuccess::withData(Adds::with(['company'])->get());
    }
}
