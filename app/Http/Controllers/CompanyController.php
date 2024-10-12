<?php

namespace App\Http\Controllers;

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

    public function getCompaniesList(): ApiSuccessResponse
    {
        return $this->service->getCompaniesList();
    }
}
