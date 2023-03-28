<?php

namespace Cjpanilag\SimpleNotifications\Traits;

use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\Notification;

/**
 * Trait UsesFcmNotificationTrait
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
trait UsesFcmNotificationTrait
{
    /**
     * @param $notifiable
     * @return array
     */
    abstract public function getData($notifiable): array;

    /**
     * @param $notifiable
     * @return string
     */
    abstract public function getTitle($notifiable): string;

    /**
     * @param $notifiable
     * @return string
     */
    abstract public function getBody($notifiable): string;

    /**
     * @param $notifiable
     * @return string|null
     */
    abstract public function getImage($notifiable): string|null;

    /**
     * @param $notifiable
     * @return mixed
     */
    public function toFcm($notifiable): mixed
    {
        $notification = Notification::create()
            ->setTitle($this->getTitle($notifiable))
            ->setBody($this->getBody($notifiable))
            ->setImage($this->getImage($notifiable));

        $androidConfig = AndroidConfig::create()
            ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
            ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'));

        $apnsConfig = ApnsConfig::create()
            ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios'));

        return FcmMessage::create()
            ->setData($this->getData($notifiable))
            ->setNotification($notification)
            ->setAndroid($androidConfig)
            ->setApns($apnsConfig);
    }

//    /**
//     * optional method when using kreait/laravel-firebase:^3.0, this method can be omitted, defaults to the default project
//     *
//     * @param $notifiable
//     * @param $message
//     * @return string
//     */
//    public function fcmProject($notifiable, $message): string
//    {
//        return 'app';
//    }
}
