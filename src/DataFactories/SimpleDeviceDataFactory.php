<?php

namespace Cjpanilag\SimpleNotifications\DataFactories;

use Cjpanilag\SimpleNotifications\Models\SimpleDevice;
use Luchavez\StarterKit\Abstracts\BaseDataFactory;
// Model
use Illuminate\Database\Eloquent\Builder;

/**
 * Class SimpleDeviceDataFactory
 *
 * @author Carl Jeffrie Panilag <carljeffrie.panilag>
 */
class SimpleDeviceDataFactory extends BaseDataFactory
{
    /**
     * @var string|null
     */
    public ?string $device_id;

    /**
     * @var string|null
     */
    public ?string $unique_id;

    /**
     * @var string|null
     */
    public ?string $brand;

    /**
     * @var string|null
     */
    public ?string $type;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $manufacturer;

    /**
     * @var string|null
     */
    public ?string $model;

    /**
     * @var string|null
     */
    public ?string $system_name;

    /**
     * @var string|null
     */
    public ?string $system_version;

    /**
     * @var string|null
     */
    public ?string $version;

    /**
     * @var bool
     */
    public bool $active = true;

    /**
     * @return Builder
     *
     * @example User::query()
     */
    public function getBuilder(): Builder
    {
        return SimpleDevice::query();
    }
}
