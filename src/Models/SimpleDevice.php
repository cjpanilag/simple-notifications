<?php

namespace Cjpanilag\SimpleNotifications\Models;

use Cjpanilag\SimpleNotifications\Traits\HasSimpleDeviceFactoryTrait;
use Luchavez\StarterKit\Traits\UsesUUIDTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SimpleDevice
 *
 * Note:
 * By default, models and factories inside a package need to explicitly connect with each other.
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class SimpleDevice extends Model
{
    use UsesUUIDTrait;
    use SoftDeletes;
    use HasSimpleDeviceFactoryTrait;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $guarded = [
        'id',
        'uuid',
        'deleted_at',
        'active',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(starterKit()->getUserModel());
    }
}
