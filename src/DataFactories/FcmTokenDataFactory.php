<?php

namespace Cjpanilag\SimpleNotifications\DataFactories;

use Cjpanilag\SimpleNotifications\Models\FcmToken;
use Luchavez\StarterKit\Abstracts\BaseDataFactory;
// Model
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FcmTokenDataFactory
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class FcmTokenDataFactory extends BaseDataFactory
{
    /**
     * @var int
     */
    public int $simple_device_id;

    /**
     * @var string
     */
    public string $token;

    /**
     * @return Builder
     *
     * @example User::query()
     */
    public function getBuilder(): Builder
    {
        return FcmToken::query();
    }
}
