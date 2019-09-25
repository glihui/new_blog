<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Http\FormRequest as BaseFormRequest;
use Dotenv\Exception\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class FormRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->container['request'] instanceof \Illuminate\Http\Request) {
            throw new ResourceException($validator->errors()->first(), null);
        }

        throw (new ValidationException($validator))
          ->errorBag($this->errorBag)
          ->redirectTo($this->getRedirectUrl());
    }
}
