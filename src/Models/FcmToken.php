<?php

namespace Cjpanilag\SimpleNotifications\Models;

use Cjpanilag\SimpleNotifications\Traits\HasFcmTokenFactoryTrait;
use Luchavez\StarterKit\Traits\UsesUUIDTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FcmToken
 *
 * Note:
 * By default, models and factories inside a package need to explicitly connect with each other.
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class FcmToken extends Model
{
    use UsesUUIDTrait;
    use SoftDeletes;
    use HasFcmTokenFactoryTrait;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'uuid',
        'deleted_at',
    ];

    /**
     * @return BelongsTo
     */
    public function simpleDevice(): BelongsTo
    {
        return $this->belongsTo(SimpleDevice::class);
    }
}
