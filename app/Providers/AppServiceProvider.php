<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->isLocal()) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }

        \API::error(function (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            abort(404);
        });


        \API::error(function (\Illuminate\Auth\Access\AuthorizationException $exception) {
            abort(403, $exception->getMessage());
        });

        \API::error(function (\Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException $exception) {
            $error = $exception->getMessage();
            return response()->json(['message'=>$error,'code'=>1, 'data' => ''], 200);
        });



        \API::error(function (\Illuminate\Validation\ValidationException $exception){
            $data =$exception->validator->getMessageBag();
            $msg = collect($data)->first();
            if(is_array($msg)){
                $msg = $msg[0];
            }
            return response()->json(['message'=>$msg,'code'=>1, 'data' => ''], 200);
        });
        \API::error(function (\Dingo\Api\Exception\ValidationHttpException $exception){
            $errors = $exception->getErrors();
            return response()->json(['message'=>$errors->first(),'code'=>1, 'data' => ''], 200);
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
