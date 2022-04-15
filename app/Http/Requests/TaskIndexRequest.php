<?php

namespace App\Http\Requests;

use App\Common\Repository\PaginableContract;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(PaginableContract::REQUEST_RULES, [
            PaginableContract::FIELD_FILTERS . '.status' => [
                'nullable',
                Rule::in(Task::STATUSES)
            ], PaginableContract::FIELD_FILTERS . '.user_id' => [
                'nullable',
                Rule::exists('users', 'id')
            ]
        ]);
    }
}
