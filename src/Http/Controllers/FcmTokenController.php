<?php

namespace Cjpanilag\SimpleNotifications\Http\Controllers;

use App\Http\Controllers\Controller;
use Cjpanilag\SimpleNotifications\DataFactories\FcmTokenDataFactory;
use Cjpanilag\SimpleNotifications\Events\FcmToken\FcmTokenCollectedEvent;
use Cjpanilag\SimpleNotifications\Events\FcmToken\FcmTokenCreatedEvent;
// Model
use Cjpanilag\SimpleNotifications\Http\Requests\FcmToken\IndexFcmTokenRequest;
// Requests
use Cjpanilag\SimpleNotifications\Http\Requests\FcmToken\StoreFcmTokenRequest;
use Cjpanilag\SimpleNotifications\Models\FcmToken;
// Events
use Cjpanilag\SimpleNotifications\Models\SimpleDevice;
use Illuminate\Http\JsonResponse;

/**
 * Class FcmTokenController
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class FcmTokenController extends Controller
{
    /**
     * FcmToken List
     *
     * @group FcmToken Management
     *
     * @param  IndexFcmTokenRequest  $request
     * @return JsonResponse
     */
    public function index(IndexFcmTokenRequest $request): JsonResponse
    {
        $data = new FcmToken();

        if ($request->has('full_data') === true) {
            $data = $data->get();
        } else {
            $data = $data->fastPaginate($request->get('per_page', 15));
        }

        event(new FcmTokenCollectedEvent($data));

        return simpleResponse()
            ->data($data)
            ->message('Successfully collected record.')
            ->success()
            ->generate();
    }

    /**
     * Store FcmToken
     *
     * @group FcmToken Management
     *
     * @param  StoreFcmTokenRequest  $request
     * @return JsonResponse
     */
    public function store(StoreFcmTokenRequest $request): JsonResponse
    {
        $data = $request->validated();

        $device = SimpleDevice::where('uuid', $data['device_uuid'])->firstOrFail();

        $data['simple_device_id'] = $device->id;

        $model = FcmTokenDataFactory::from($data)->create();

        event(new FcmTokenCreatedEvent($model));

        return simpleResponse()
            ->data($model)
            ->message('Successfully created record.')
            ->success()
            ->generate();
    }
}
