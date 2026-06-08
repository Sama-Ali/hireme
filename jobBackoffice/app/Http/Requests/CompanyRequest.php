<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'industry' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'owner_id' => [request()->routeIs('my-company.*') ? 'prohibited' : 'required', 'exists:users,id'],
        ];
    }
}