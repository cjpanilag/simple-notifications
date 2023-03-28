<?php

namespace Cjpanilag\SimpleNotifications\Models;

use Cjpanilag\SimpleNotifications\Traits\HasFcmNotifiableTrait;
use Cjpanilag\SimpleNotifications\Traits\HasMailNotifiableTrait;
use Cjpanilag\SimpleNotifications\Traits\HasSnsNotifiableTrait;
use Illuminate\Contracts\Auth\Authenticatable as User;

/**
 * Class DummyUser
 *
 * Note:
 * By default, models and factories inside a package need to explicitly connect with each other.
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class DummyUser extends User
{
    use HasSnsNotifiableTrait;
    use HasFcmNotifiableTrait;
    use HasMailNotifiableTrait;

    /**
     * @param  string|null  $mobile
     * @param  string|array|null  $email
     * @param  string|array|null  $fcmToken
     */
    public function __construct(
        public string|null $mobile = null,
        public string|array|null $email = null,
        public string|array|null $fcmToken = null
    ) {
        parent::__construct();
    }

    /**
     * @return string|array
     */
    public function routeNotificationForFcm(): string|array
    {
        return $this->fcmToken;
    }

    /**
     * @param $notification
     * @return array|string|null
     */
    public function routeNotificationForMail($notification): array|string|null
    {
        return $this->email;
    }

    /**
     * @param
     * @return string|null
     */
    public function routeNotificationForSns($notification): string|null
    {
        return $this->mobile;
    }
}
