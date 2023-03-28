<?php

namespace Cjpanilag\SimpleNotifications\Traits;

use Cjpanilag\SimpleNotifications\Database\Factories\FcmTokenFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Trait HasFcmTokenFactoryTrait
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
trait HasFcmTokenFactoryTrait
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return FcmTokenFactory::new();
    }
}
