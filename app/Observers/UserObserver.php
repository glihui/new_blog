<?php
/**
 * Created by PhpStorm.
 * User: guolihui
 * Date: 2019/8/31
 * Time: 下午2:45
 */
namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function saving(User $user)
    {
        // 这样写扩展性更高， 只有空的时候才指定默认头像
        if (empty($user->avatar)) {
            $user->avatar = 'http://bbs.guolh.com/uploads/images/avatars/201810/13//1_1539417887_r1N0tbukAX.jpeg';
        }
    }
}