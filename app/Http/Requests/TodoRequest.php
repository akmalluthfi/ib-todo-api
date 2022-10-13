<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\JsonRequest;

class TodoRequest extends JsonRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3|max:150',
            'description' => 'required|min:3|max:150',
            'due_date' => 'required|date_format:Y-m-d\TH:i',
            'is_complete' => 'required|boolean',
        ];
    }
}
