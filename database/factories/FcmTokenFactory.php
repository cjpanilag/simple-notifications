<?php

namespace Cjpanilag\SimpleNotifications\Database\Factories;

// Model
use Cjpanilag\SimpleNotifications\Models\FcmToken;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class FcmToken
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class FcmTokenFactory extends Factory
{
    protected $model = FcmToken::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
