<?php

namespace Cjpanilag\SimpleNotifications\Traits;

use Illuminate\Notifications\Notifiable;

/**
 * Trait HasFcmNotifiableTrait
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
trait HasFcmNotifiableTrait
{
    use Notifiable;

    /**
     * @return string|array
     */
    abstract public function routeNotificationForFcm(): string|array;
}
