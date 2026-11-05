<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Param;

use App\Enums\Param\ParamFilterTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'filter_type' => ['required', Rule::enum(ParamFilterTypeEnum::class)],
        ];
    }
}
