<?php

namespace App\Service;

use App\Facades\ApiSuccess;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyService extends BaseService
{
    public function __construct()
    {
        $this->model = Company::class;
        $this->storeRequest = CreateCompanyRequest::class;
        $this->updateRequest = UpdateCompanyRequest::class;
        $this->relations = ['user'];
    }

    public function get(Request $request): ApiSuccessResponse
    {
        return ApiSuccess::withData(Company::with(['user'])->get());
    }

    public function getCompaniesList(): ApiSuccessResponse
    {
        return ApiSuccess::withData($this->model::orderBy('company_name')->get());
    }
}
