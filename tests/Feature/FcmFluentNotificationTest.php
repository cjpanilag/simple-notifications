<?php

declare(strict_types=1);

namespace Cjpanilag\SimpleNotifications\Feature;

use Tests\TestCase;

/**
 * Class FcmFluentNotificationTest
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class FcmFluentNotificationTest extends TestCase
{
    /**
     * Testing default method chaining.
     *
     *  ex. pattern:
     *          simpleNotifications()
     *          fcm()
     *          user(<Model>)               | Optional
     *          data(<array>)               | Optional
     *          body(<string|callable>)     | Optional
     *          title(<string|callable>)    | Optional
     *          image(<string|callable>)    | Optional
     *          execute()                   | Required
     *
     * @test
     */
    public function can_send_fcm_default_fluent_method(): void
    {
        $response = $this->get('/api/test/fcm/default');
        $response->assertStatus(200);
    }
}
