<?php

namespace App\Observers;

use App\Models\Zans;

class ZanObserver
{
    public function created(Zans $zan)
    {
        $topic = $zan->topic;
        $topic->increment('zan_count', 1);
    }
}
