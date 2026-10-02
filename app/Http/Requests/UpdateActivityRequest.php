<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $activityId = $this->route('activity')?->id;

        return [
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'code' => [
                'required',
                'string',
                'max:30',
                Rule::unique('activities', 'code')->ignore($activityId),
            ],
            'title' => [
                'required',
                'string',
                'min:5',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'start_at' => [
                'required',
                'date',
            ],
            'end_at' => [
                'required',
                'date',
                'after_or_equal:start_at',
            ],
            'location' => [
                'required',
                'string',
                'max:150',
            ],
            'capacity' => [
                'required',
                'integer',
                'min:1',
                'max:500',
            ],
        ];
    }
}