<?php

namespace App\Service;

use App\Facades\ApiSuccess;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\Adds;
use App\Models\Company;
use Illuminate\Http\Request;

class AddsService extends BaseService
{
    public function __construct()
    {
        $this->model = Adds::class;
    }

    public function get(Request $request): ApiSuccessResponse
    {
        return ApiSuccess::withData(Adds::with(['company'])->get());
    }

    public function update($request): ApiSuccessResponse
    {
        /* @var Company $item */
        $item = $this->model::findOrFail($request->route('id'));
        $item->update($request->validated());

        return ApiSuccess::withData($item->load(['company']));
    }
}
