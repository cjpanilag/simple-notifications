<?php

declare(strict_types=1);

namespace Cjpanilag\SimpleNotifications\Http\Controllers;

use App\Http\Controllers\Controller;
use Cjpanilag\SimpleNotifications\Exceptions\UndefinedUserException;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\AwsSns\SnsMessage;

/**
 * Class TestController
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class TestController extends Controller
{
    /**
     * @return void
     * @throws UndefinedUserException
     */
    public function snsDefault(): void
    {
        $user = starterKit()->getUserQueryBuilder()->firstOrFail();
        simpleNotifications()->sns()->user($user)->content('No content')->execute();
    }

    /**
     * @return void
     * @throws UndefinedUserException
     */
    public function snsUsingMobile(): void
    {
        simpleNotifications()->sns()->mobile('+639123456789')->content('No content')->execute();
    }

    /**
     * @return void
     * @throws UndefinedUserException
     */
    public function snsUsingContentWithUser(): void
    {
        $user = starterKit()->getUserQueryBuilder()->firstOrFail();

        simpleNotifications()->sns()->user($user)->content(function ($user) {
            $snsMessage = new SnsMessage('test data');

            $snsMessage->sender('FIN-PAY');
            $snsMessage->transactional(true);

            return $snsMessage;
        })->execute();
    }

    /**
     * @return void
     * @throws UndefinedUserException
     */
    public function snsUsingMobileContent(): void
    {
        simpleNotifications()->sns()->mobile('+639123456789')->content(function ($user) {
            $snsMessage = new SnsMessage('test data');

            $snsMessage->sender('FIN-PAY');
            $snsMessage->transactional(true);

            return $snsMessage;
        })->execute();
    }

    /**
     * @return void
     * @throws UndefinedUserException
     */
    public function mailDefault(): void
    {
        $user = starterKit()->getUserQueryBuilder()->firstOrFail();

        simpleNotifications()->mail()
            ->user($user)
            ->subject('Test Subject 123')
            ->body('test body')
            ->footer('test footer')
            ->actionMessage('PUSH ME!')
            ->actionUrl('http://localhost')
            ->execute();
    }

    /**
     * @return void
     * @throws UndefinedUserException
     */
    public function snsUsingMail(): void
    {
        simpleNotifications()->mail()
            ->emailAddress('testemail123@gmail.com')
            ->subject('Test Subject 123')
            ->body('test body')
            ->footer('test footer')
            ->actionMessage('PUSH ME!')
            ->actionUrl('http://localhost')
            ->execute();
    }

    /**
     * @return void
     * @throws UndefinedUserException
     */
    public function mailUsingContentWithUser(): void
    {
        $user = starterKit()->getUserQueryBuilder()->firstOrFail();

        simpleNotifications()->mail()->user($user)->content(function ($user) {
            $mailMessage = new MailMessage();
            $subject = 'test subject 2';

            if ($user) {
                $mailMessage->subject($subject);
            }

            $mailMessage->line('this is a best body number 2')
                ->action('PUSH ME!', 'https://test.com')
                ->line('this is a test footer 2');

            return $mailMessage;
        })->execute();
    }

    /**
     * @throws UndefinedUserException
     */
    public function mailUsingEmailContent(): void
    {
        simpleNotifications()->mail()->emailAddress('testemail123@gmail.com')->content(function ($user) {
            $mailMessage = new MailMessage();
            $subject = 'test subject 2';

            if ($user) {
                $mailMessage->subject($subject);
            }

            $mailMessage->line('this is a best body number 2')
                ->action('PUSH ME!', 'https://test.com')
                ->line('this is a test footer 2');

            return $mailMessage;
        })->execute();
    }

    /**
     * @return void
     * @throws UndefinedUserException
     */
    public function fcmDefault(): void
    {
        $user = starterKit()->getUserQueryBuilder()->firstOrFail();

        simpleNotifications()
            ->fcm()
            ->user($user)
            ->data([])
            ->title('Welcome Test')
            ->body('just test')
            ->execute();
    }
}
