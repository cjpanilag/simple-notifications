<?php

namespace Cjpanilag\SimpleNotifications\Notifications;

use Cjpanilag\SimpleNotifications\Exceptions\UndefinedUserException;
use Cjpanilag\SimpleNotifications\Models\DummyUser;
use Cjpanilag\SimpleNotifications\Traits\UsesFcmNotificationTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;

/**
 * Class FcmNotification
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class FcmNotification extends Notification
{
    use Queueable;
    use UsesFcmNotificationTrait;

    /**
     * @var User|null
     */
    protected ?User $user = null;

    /**
     * Create a new notification instance.
     *
     * @param  string|null  $token
     */
    public function __construct(
        string $token = null,
        protected string|null $title = null,
        protected string|null $body = null,
        protected string|null $image = null,
        protected array|null $data = null
    ) {
        if ($token) {
            $this->token($token);
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return [FcmChannel::class];
    }

    /**
     * @param  mixed  $user
     * @return $this
     */
    public function user(mixed $user): static
    {
        $this->user = (is_subclass_of($user, User::class)) ? $user : User::query()->findOrFail($user);

        return $this;
    }

    /**
     * @param  string  $token
     * @return $this
     */
    public function token(string $token): static
    {
        return $this->user(new DummyUser(fcmToken: $token));
    }

    /**
     * @param  array  $data
     * @return $this
     */
    public function data(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param $notifiable
     * @return array
     */
    public function getData($notifiable): array
    {
        return  empty($this->data) ? ['data1' => 'value', 'data2' => 'value2'] : $this->data;
    }

    /**
     * @param  string|callable  $title
     * @return $this
     */
    public function title(string|callable $title): static
    {
        if (is_callable($title)) {
            $title = $title($this->user);
        }

        $this->title = $title;

        return $this;
    }

    /**
     * @param $notifiable
     * @return string
     */
    public function getTitle($notifiable): string
    {
        return  empty($this->title) ? 'Test Notification' : $this->title;
    }

    /**
     * @param  string|callable  $body
     * @return $this
     */
    public function body(string|callable $body): static
    {
        if (is_callable($body)) {
            $body = $body($this->user);
        }

        $this->body = $body;

        return $this;
    }

    /**
     * @param $notifiable
     * @return string
     */
    public function getBody($notifiable): string
    {
        return  empty($this->body) ? "A Notification for $notifiable->name" : $this->body;
    }

    /**
     * @param  string|callable  $image
     * @return $this
     */
    public function image(string|callable $image): static
    {
        if (is_callable($image)) {
            $image = $image($this->user);
        }

        $this->image = $image;

        return $this;
    }

    /**
     * @param $notifiable
     * @return string|null
     */
    public function getImage($notifiable): string|null
    {
        return $this->image;
    }

    /**
     * @return void
     *
     * @throws UndefinedUserException
     */
    public function execute(): void
    {
        if (! $this->user) {
            throw new UndefinedUserException();
        }

        if (class_uses_trait($this->user, Notifiable::class)) {
            $this->user->notify($this);
        }
    }
}
