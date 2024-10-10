<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\CreateRequest;

class CreateCompanyRequest extends CreateRequest
{
    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'unique:companies,company_name'],
            'status' => ['nullable', 'string', 'in:В ожидании,Активен,В архиве'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'company_name' => 'Название компании',
            'status' => 'Статус',
            'user_id' => 'Основатель',
        ];
    }
}
