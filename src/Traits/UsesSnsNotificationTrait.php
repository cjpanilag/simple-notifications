<?php

namespace Cjpanilag\SimpleNotifications\Traits;

use Illuminate\Support\Str;
use NotificationChannels\AwsSns\SnsMessage;

/**
 * Trait UsesSnsNotificationTrait
 *
 * @note Make sure to add `SnsChannel Class` to the Notification's `via` function
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
trait UsesSnsNotificationTrait
{
    /**
     * @param $notifible
     * @return string
     */
    abstract public function getSnsContent($notifible): string;

    /**
     * @param $notifible
     * @return bool
     */
    abstract public function getSnsTransactional($notifible): bool;

    /**
     * Override this if you want to change sender name.
     *
     * @param $notifible
     * @return string
     */
    public function getSnsSender($notifible): string
    {
        return config('app.name');
    }

    /**
     * @param $notifiable
     * @return SnsMessage
     */
    public function toSns($notifiable): SnsMessage
    {
        $sender = $this->getSnsSender($notifiable);

        // Refer to sender method in the documentation: https://github.com/laravel-notification-channels/aws-sns#available-snsmessage-methods
        $sender = Str::substr((preg_replace('/[^a-z]/i', '', $sender)), 0, 10);

        return SnsMessage::create()
            ->body($this->getSnsContent($notifiable))
            ->transactional($this->getSnsTransactional($notifiable))
            ->sender($sender);
    }
}
