<?php 

namespace App\Traits;

use App\Models\Pura;

trait NotificationTrait {

    public function checkNotificationCctv(Pura $pura)
    {
        return boolval($pura->notification_cctv);
    }

}