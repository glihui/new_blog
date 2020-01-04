<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'img_url' => 'required|string',
                    'link' => 'required|string',
                ];
                break;
            case 'PATCH':
                return [
                    'img_url' => 'string',
                    'link' => 'string',
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
            'img_url' => 'banner图片url',
            'link' => 'banner链接'
        ];
    }
}
