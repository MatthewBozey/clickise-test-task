<?php

namespace App\Http\Requests\Adds;

use App\Http\Requests\FailedValidationHandleRequest;

class CreateAddsRequest extends FailedValidationHandleRequest
{
    public function rules(): array
    {
        return [
            'company_id' => ['required', 'integer', 'exists:companies,id'],
            'title' => ['required', 'string', 'max:255', 'unique:adds,title'],
            'text' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:В ожидании,Активен,В архиве'],
            'url' => ['required', 'url'],
            'impressions_count' => ['nullable', 'integer', 'min:0'],
            'crm' => ['required', 'integer', 'min:0'],
            'budget' => ['required', 'integer', 'min:0'],
            'button_text' => ['required', 'string', 'in:Смотреть,Оставить заявку,Скачать,Подробнее'],
        ];
    }
}
