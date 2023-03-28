<?php

namespace Cjpanilag\SimpleNotifications\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class SimpleNotifications
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 *
 * @see \Cjpanilag\SimpleNotifications\Services\SimpleNotifications
 */
class SimpleNotifications extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'simple-notifications';
    }
}
