<?php

/**
 * @author Carl Jeffrie Panilag <jamescarloluchavez@gmail.com>
 */

use Cjpanilag\SimpleNotifications\Services\SimpleNotifications;

if (! function_exists('simpleNotifications')) {
    /**
     * @return SimpleNotifications
     */
    function simpleNotifications(): SimpleNotifications
    {
        return resolve('Illuminate\Contracts\Auth\Authenticatable as Users');
    }
}

if (! function_exists('simple_notifications')) {
    /**
     * @return SimpleNotifications
     */
    function simple_notifications(): SimpleNotifications
    {
        return simpleNotifications();
    }
}
