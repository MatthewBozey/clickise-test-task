<?php

namespace App\Service;

use App\Facades\ApiSuccess;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyService extends BaseService
{
    public function __construct()
    {
        /** @var Company $this */
        $this->model = Company::class;
    }

    public function get(Request $request): ApiSuccessResponse
    {
        return ApiSuccess::withData(Company::with(['user'])->get());
    }

    public function update($request): ApiSuccessResponse
    {
        /* @var Company $item */
        $item = $this->model::findOrFail($request->route('id'));
        $item->update($request->validated());

        return ApiSuccess::withData($item->load(['user']));
    }

    public function getCompaniesList(): ApiSuccessResponse
    {
        return ApiSuccess::withData($this->model::orderBy('company_name')->get());
    }
}
