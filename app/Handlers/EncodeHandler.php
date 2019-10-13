<?php
/**
 * Created by PhpStorm.
 * User: guolihui
 * Date: 2019/10/13
 * Time: 下午2:19
 */

namespace App\Handlers;

use Dingo\Api\Http\Response\Format\Json;

class EncodeHandler extends json{
    protected function encode($content)
    {
        $jsonEncodeOptions = [];

        if ($this->isJsonPrettyPrintEnabled()) {
            $jsonEncodeOptions[] = JSON_PRETTY_PRINT;
        }
        if ($content['code'] == 1) {
            $newContent = $content;
        } else {
            $newContent['data'] = $content;
            $newContent['code'] = 0;
            $newContent['message'] = '成功';
        }


        $encodedString = $this->performJsonEncoding($newContent, $jsonEncodeOptions);

        if ($this->isCustomIndentStyleRequired()) {
            $encodedString = $this->indentPrettyPrintedJson(
                $encodedString,
                $this->options['indent_style']
            );
        }
        return $encodedString;
    }
}