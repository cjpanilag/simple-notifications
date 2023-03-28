<?php

namespace Cjpanilag\SimpleNotifications\Feature;

use Tests\TestCase;

/**
 * Class SnsFluentNotificationTest
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class SnsFluentNotificationTest extends TestCase
{
    /**
     * Send default notification with <User> model method chaining:
     *
     *  ex. pattern:
     *      simpleNotifications()
     *      sns()
     *      user(<Model>)
     *      content(<string>)
     *      execute()
     *
     * @test
     */
    public function can_send_default_user_sns(): void
    {
        $response = $this->get('/api/test/sns/default');
        $response->assertStatus(200);
    }

    /**
     * Send default notification using mobile method chaining:
     *
     *  ex. pattern:
     *          simpleNotifications()
     *          sns()
     *          mobile(<string>)
     *          content(<string>)
     *          execute()
     *
     * @test
     */
    public function can_send_default_sns_using_specific_mobile(): void
    {
        $response = $this->get('/api/test/sns/mobile');
        $response->assertStatus(200);
    }

    /**
     * Send SNS notification using <content> fluent method.
     *
     *  ex. pattern:
     *          simpleNotifications()
     *          sns()
     *          user(<Model>)
     *          content(<callable|string>)
     *          execute()
     *
     * @test
     */
    public function can_send_sns_using_content_method_with_user(): void
    {
        $response = $this->get('/api/test/sns/content-user');
        $response->assertStatus(200);
    }

    /**
     * Send SNS notification using <content> fluent method without <User>
     *
     *  ex. pattern:
     *          simpleNotifications()
     *          sns()
     *          mobile(<string>)
     *          content(<callable|string>)
     *          execute()
     *
     * @test
     */
    public function can_send_sns_using_content_method_without_user(): void
    {
        $response = $this->get('/api/test/sns/content-mobile');
        $response->assertStatus(200);
    }
}
