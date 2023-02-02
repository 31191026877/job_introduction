<?php

namespace App\Http\Requests\Post;

use App\Enums\PostCurrencySalaryEnum;
use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class   StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'company' => [
                'string',
                'nullable',
            ],
            'languages' => [
                'required',
                'array',
                'filled',
            ],
            'city' => [
                'string',
                'filled',
            ],
            'district' => [
                'string',
                'nullable',
            ],
            'currency_salary' => [
                'required',
                'numeric',
                Rule::in(PostCurrencySalaryEnum::getValues()),
            ],
            'number_applicants' => [
                'nullable',
                'numeric',
                'min:1',
            ],
            'remotables' => [
                'required',
                'array',
            ],
            'is_parttime' => [
                'nullable',
            ],
            'start_date' => [
                'nullable',
                'date',
                'before:end_date',
            ],
            'end_date' => [
                'nullable',
                'date',
                'after:start_date',
            ],
            'job_title' => [
                'required',
                'string',
                'filled',
                'min:3',
                'max:255',
            ],
            'slug' => [
                'required',
                'string',
                'filled',
                'min:3',
                'max:255',
                Rule::unique(Post::class),
            ],
        ];
        $rules['min_salary'] = [
            'nullable',
            'numeric',
        ];
        if (!empty($this->max_salary)) {
            $rules['min_salary'][] = 'lt:max_salary';
        }

        $rules['max_salary'] = [
            'nullable',
            'numeric',
        ];
        if (!empty($this->min_salary)) {
            $rules['max_salary'][] = 'gt:min_salary';
        }
        return $rules;
    }
}
