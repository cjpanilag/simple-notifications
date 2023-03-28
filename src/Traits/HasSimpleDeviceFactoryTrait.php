<?php

namespace Cjpanilag\SimpleNotifications\Traits;

use Cjpanilag\SimpleNotifications\Database\Factories\SimpleDeviceFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Trait HasSimpleDeviceFactoryTrait
 *
 * @author Carl Jeffrie Panilag <carljeffrie.panilag>
 */
trait HasSimpleDeviceFactoryTrait
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return SimpleDeviceFactory::new();
    }
}
