<?php

namespace Cjpanilag\SimpleNotifications\Services;

use Cjpanilag\SimpleNotifications\Notifications\FcmNotification;
use Cjpanilag\SimpleNotifications\Notifications\MailNotification;
use Cjpanilag\SimpleNotifications\Notifications\SnsNotification;

/**
 * Class SimpleNotifications
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class SimpleNotifications
{
    /**
     * @param  string|null  $mobile
     * @param  string|null  $content
     * @return SnsNotification
     */
    public function sns(string $mobile = null, string $content = null): SnsNotification
    {
        return new SnsNotification($mobile, $content);
    }

    /**
     * @param  string|null  $email
     * @param  string|null  $subject
     * @param  string|null  $body
     * @param  string|null  $action_message
     * @param  string|null  $action_url
     * @param  string|null  $footer
     * @return MailNotification
     */
    public function mail(
        string $email = null,
        string $subject = null,
        string $body = null,
        string $action_message = null,
        string $action_url = null,
        string $footer = null,
    ): MailNotification {
        return new MailNotification(
            email: $email,
            subject: $subject,
            body: $body,
            action_message: $action_message,
            action_url: $action_url,
            footer: $footer
        );
    }

    /**
     * @param  string|null  $token
     * @param  string|null  $title
     * @param  string|null  $body
     * @param  string|null  $image
     * @param  array|null  $data
     * @return FcmNotification
     */
    public function fcm(
        string $token = null,
        string $title = null,
        string $body = null,
        string $image = null,
        array $data = null
    ): FcmNotification {
        return new FcmNotification(
            token: $token,
            title: $title,
            body: $body,
            image: $image,
            data: $data
        );
    }
}
