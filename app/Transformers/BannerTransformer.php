<?php
/**
 * Created by PhpStorm.
 * User: guolihui
 * Date: 2020/1/3
 * Time: 下午10:59
 */

namespace App\Transformers;

use App\Models\Banner;
use League\Fractal\TransformerAbstract;

class BannerTransformer extends TransformerAbstract
{
    public function transform(Banner $banner)
    {
        return [
            'id' => $banner->id,
            'img_url' => $banner->img_url,
            'link' => $banner->link,
        ];
    }
}