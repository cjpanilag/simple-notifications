<?php

namespace Cjpanilag\SimpleNotifications\Feature;

use App\Models\User;
use Cjpanilag\SimpleNotifications\Notifications\FcmNotification;
use Cjpanilag\SimpleNotifications\Notifications\MailNotification;
use Cjpanilag\SimpleNotifications\Notifications\SnsNotification;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\AwsSns\SnsChannel;
use NotificationChannels\Fcm\FcmChannel;
use Tests\TestCase;

/**
 * Class SimpleNotificationTest
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class SimpleNotificationTest extends TestCase
{
    /**
     * Test SNS Notification
     *
     * @test
     */
    public function can_send_sns_notification(): void
    {
        Notification::fake();

        $notifiable = User::first();

        if (empty($notifiable->routeNotificationForSns($notifiable))) {
            $this->fail("User test doesn't have phone_number");
        }

        $notifiable->notify(new SnsNotification());

        Notification::assertSentTo(
            $notifiable,
            SnsNotification::class,
            function ($notification, $channels) {
                return in_array(SnsChannel::class, $channels);
            }
        );
    }

    /**
     * Mail Notification testing
     *
     * @test
     */
    public function can_send_mail_notification(): void
    {
        Notification::fake();

        $notifiable = User::first();

        if (empty($notifiable->routeNotificationForMail($notifiable))) {
            $this->fail("User test doesn't have email");
        }

        $notifiable->notify(new MailNotification());

        Notification::assertSentTo(
            $notifiable,
            MailNotification::class,
            function ($notification, $channels) {
                return in_array('mail', $channels);
            }
        );
    }

    /**
     * FCM Notification testing
     *
     * @test
     */
    public function can_send_fcm_notification(): void
    {
        Notification::fake();

        $notifiable = User::first();

        if (empty($notifiable->routeNotificationForFcm())) {
            $this->fail("User test doesn't have Firebase token!");
        }

        $notifiable->notify(new FcmNotification());

        Notification::assertSentTo(
            $notifiable,
            FcmNotification::class,
            function ($notification, $channels) {
                return in_array(FcmChannel::class, $channels);
            }
        );
    }
}
