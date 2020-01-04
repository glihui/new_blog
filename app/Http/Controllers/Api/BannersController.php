<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use App\Http\Requests\Api\BannerRequest;
use App\Transformers\BannerTransformer;


class BannersController extends Controller
{
    public function index()
    {
        return $this->response->collection(Banner::all(), new BannerTransformer());
    }

    public function store(BannerRequest $request, Banner $banner)
    {
        $banner->img_url = $request->img_url;
        $banner->link = $request->link;
        $banner->save();

        return $this->response->item($banner, new BannerTransformer())
            ->setStatusCode(201);
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $banner->update($request->all());
        return $this->response->item($banner, new BannerTransformer());
    }

    public function destroy(Banner $banner) {
        $banner->delete();
        return $this->response->noContent();
    }
}
