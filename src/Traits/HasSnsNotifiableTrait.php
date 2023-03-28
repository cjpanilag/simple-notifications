<?php

namespace Cjpanilag\SimpleNotifications\Traits;

use Illuminate\Notifications\Notifiable;

/**
 * Trait HasSnsNotifiableTrait
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
trait HasSnsNotifiableTrait
{
    use Notifiable;

    /**
     * @param
     * @return string|null
     */
    abstract public function routeNotificationForSns($notification): string|null;
}
