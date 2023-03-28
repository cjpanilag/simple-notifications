<?php

namespace Cjpanilag\SimpleNotifications\Traits;

use Illuminate\Notifications\Notifiable;

/**
 * Trait HasMailNotifiableTrait
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
trait HasMailNotifiableTrait
{
    use Notifiable;

    /**
     * @param $notification
     * @return array|string|null
     */
    abstract public function routeNotificationForMail($notification): array|string|null;
}
