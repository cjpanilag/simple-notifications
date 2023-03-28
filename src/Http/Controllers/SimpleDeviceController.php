<?php

namespace Cjpanilag\SimpleNotifications\Http\Controllers;

use App\Http\Controllers\Controller;
use Cjpanilag\SimpleNotifications\DataFactories\SimpleDeviceDataFactory;
use Cjpanilag\SimpleNotifications\Events\SimpleDevice\SimpleDeviceCollectedEvent;
// Model
use Cjpanilag\SimpleNotifications\Events\SimpleDevice\SimpleDeviceCreatedEvent;
// Requests
use Cjpanilag\SimpleNotifications\Http\Requests\SimpleDevice\IndexSimpleDeviceRequest;
use Cjpanilag\SimpleNotifications\Http\Requests\SimpleDevice\StoreSimpleDeviceRequest;
// Events
use Cjpanilag\SimpleNotifications\Models\SimpleDevice;
use Illuminate\Http\JsonResponse;

/**
 * Class SimpleDeviceController
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class SimpleDeviceController extends Controller
{
    /**
     * SimpleDevice List
     *
     * @group SimpleDevice Management
     *
     * @param  IndexSimpleDeviceRequest  $request
     * @return JsonResponse
     */
    public function index(IndexSimpleDeviceRequest $request): JsonResponse
    {
        $data = new SimpleDevice();

        if ($request->has('full_data') === true) {
            $data = $data->get();
        } else {
            $data = $data->fastPaginate($request->get('per_page', 15));
        }

        event(new SimpleDeviceCollectedEvent($data));

        return simpleResponse()
            ->data($data)
            ->message('Successfully collected record.')
            ->success()
            ->generate();
    }

    /**
     * Store SimpleDevice
     *
     * @group SimpleDevice Management
     *
     * @param  StoreSimpleDeviceRequest  $request
     * @return JsonResponse
     *
     * @throws \ReflectionException
     */
    public function store(StoreSimpleDeviceRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = starterKit()->getUserQueryBuilder()->findOrFail($data['user_id']);

        $model = SimpleDeviceDataFactory::from($data)->create();

        $user->simpleDevices()->save($model);

        event(new SimpleDeviceCreatedEvent($model));

        return simpleResponse()
            ->data($model)
            ->message('Successfully created record.')
            ->success()
            ->generate();
    }
}
