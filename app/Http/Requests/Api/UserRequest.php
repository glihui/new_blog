<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = \Auth::guard('api')->id();

        return [
            'avatar_image_id' => 'exists:images,id,type,avatar,user_id,'.$userId,
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
