<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class JsonRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  abstract public function rules();

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  abstract public function authorize();

  /**
   * Handle a failed validation attempt.
   *
   * @param  \Illuminate\Contracts\Validation\Validator $validator
   * @return void
   *
   * @throws \Illuminate\Http\Exceptions\HttpResponseException
   */
  protected function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(
      response()->json([
        'message' => 'Validation Error',
        'data' => null,
        'error' => $validator->errors()
      ])
    );
  }
}
