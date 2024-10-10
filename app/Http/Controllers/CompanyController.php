<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Service\CompanyService;
use Illuminate\Routing\Controllers\Middleware;

class CompanyController extends BaseController
{
    public function __construct(CompanyService $service)
    {
        parent::__construct($service);
    }

    public static function middleware()
    {
        return [
            new Middleware('checkCompanyExists', only: ['destroy', 'show', 'update']),
        ];
    }

    public function store(CreateCompanyRequest $request): ApiSuccessResponse
    {
        return $this->service->store($request);
    }

    public function update(UpdateCompanyRequest $request): ApiSuccessResponse
    {
        return $this->service->update($request);
    }

    public function getCompaniesList()
    {
        return $this->service->getCompaniesList();
    }
}
