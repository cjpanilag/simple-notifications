<?php

declare(strict_types=1);

namespace Cjpanilag\SimpleNotifications\Feature;

use App\Models\User;
use Tests\TestCase;

/**
 * Class MailFluentNotificationTest
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class MailFluentNotificationTest extends TestCase
{
    /**
     * Send default notification with <User> model method chaining:
     * ex.
     *      simpleNotifications()
     *      user(User::first())
     *      subject()
     *      body()
     *      footer()
     *      actionMessage()
     *      actionUrl()
     *      execute()
     *
     * @test
     */
    public function can_send_default_user_mail(): void
    {
        $response = $this->get('/api/test/mail/default');
        $response->assertStatus(200);
    }

    /**
     * Send default notification using <emailAddress> method chaining:
     * ex.
     *      simpleNotifications()
     *      email(<email_address>)
     *      subject()
     *      body()
     *      footer()
     *      actionMessage()
     *      actionUrl()
     *      execute()
     *
     * @test
     */
    public function can_send_default_mail_using_specific_email(): void
    {
        $response = $this->get('/api/test/mail/with-email');
        $response->assertStatus(200);
    }

    /**
     * Send mail notification using <content> fluent method.
     *
     *  ex. pattern:
     *      simpleNotifications()
     *      mail()
     *      user(<Model>)
     *      content(<callable|string>)
     *      execute()
     *
     * @test
     */
    public function can_send_mail_using_content_method_with_user()
    {
        $response = $this->get('/api/test/mail/content-user');
        $response->assertStatus(200);
    }

    /**
     * Send mail notification using <content> fluent method without <User>
     *
     *  ex. pattern:
     *      simpleNotifications()
     *      mail()
     *      emailAddress(<email_address>)
     *      content(<callable|string>)
     *      execute()
     *
     * @test
     */
    public function can_send_mail_using_content_method_without_user(): void
    {
        $response = $this->get('/api/test/mail/content-email');
        $response->assertStatus(200);
    }
}
