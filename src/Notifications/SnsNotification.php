<?php

namespace Cjpanilag\SimpleNotifications\Notifications;

use Cjpanilag\SimpleNotifications\Exceptions\UndefinedUserException;
use Cjpanilag\SimpleNotifications\Models\DummyUser;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use NotificationChannels\AwsSns\Sns;
use NotificationChannels\AwsSns\SnsChannel;
use NotificationChannels\AwsSns\SnsMessage;

/**
 * Class SnsNotification
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class SnsNotification extends Notification
{
    use Queueable;

    /**
     * @var User|null
     */
    protected ?User $user = null;

    /**
     * @var SnsMessage|string|null
     */
    protected SnsMessage|string|null $content = null;

    /**
     * @var string|null
     */
    protected ?string $message = null;

    /**
     * @var bool
     */
    protected bool $transactional = true;

    /**
     * Create a new notification instance.
     *
     * @param  string|null  $mobile
     */
    public function __construct(string $mobile = null, SnsMessage|string $content = null)
    {
        if ($mobile) {
            $this->mobile($mobile);
        }

        if ($content) {
            $this->content($content);
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
        return [SnsChannel::class];
    }

    /**
     * User base notification
     *
     * @param  User|Model|int  $user
     * @return $this
     */
    public function user(mixed $user): static
    {
        $this->user = (is_subclass_of($user, User::class)) ? $user : User::query()->findOrFail($user);

        return $this;
    }

    /**
     * Method for Userless notification
     *
     * @param  string  $mobile
     * @return $this
     */
    public function mobile(string $mobile): static
    {
        return $this->user(new DummyUser(mobile: $mobile));
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

    /**
     * @param  SnsMessage|string|callable  $content
     * @return $this
     */
    public function content(SnsMessage|string|callable $content): static
    {
        if (is_callable($content)) {
            $content = $content($this->getUser());
        }

        $this->content = $content;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

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
     * @param  string|null  $message
     * @return $this
     */
    public function message(?string $message = null): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param  bool  $value
     * @return $this
     */
    public function transactional(bool $value): static
    {
        $this->transactional = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function getTransactional(): bool
    {
        return $this->transactional;
    }

    /**
     * @param $notifiable
     * @return SnsMessage
     */
    public function toSns($notifiable): SnsMessage
    {
        if ($this->content instanceof SnsMessage) {
            return $this->content;
        }

        $sender = $this->getSnsSender($notifiable);

        // Refer to sender method in the documentation: https://github.com/laravel-notification-channels/aws-sns#available-snsmessage-methods
        $sender = Str::substr((preg_replace('/[^a-z]/i', '', $sender)), 0, 10);

        return SnsMessage::create()
            ->body($this->content)
            ->transactional($this->getTransactional())
            ->sender($sender);
    }
}
