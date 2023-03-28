<?php

namespace Cjpanilag\SimpleNotifications\Notifications;

use Cjpanilag\SimpleNotifications\Exceptions\UndefinedUserException;
use Cjpanilag\SimpleNotifications\Models\DummyUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

/**
 * Class MailNotification
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class MailNotification extends Notification
{
    use Queueable;

    /**
     * @var MailMessage|null
     */
    protected ?MailMessage $content = null;

    /**
     * @var User|null
     */
    protected ?User $user = null;

    /**
     * Create a new notification instance.
     *
     * @param  string|null  $email
     * @param  string|null  $subject
     * @param  string|null  $body
     * @param  string|null  $action_message
     * @param  string|null  $action_url
     * @param  string|null  $footer
     */
    public function __construct(
        string $email = null,
        protected string|null $subject = null,
        protected string|null $body = null,
        protected string|null $action_message = null,
        protected string|null $action_url = null,
        protected string|null $footer = null
    ) {
        if ($email) {
            $this->email($email);
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
        return ['mail'];
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
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param  string  $email
     * @return $this
     */
    public function emailAddress(string $email): static
    {
        return $this->user(new DummyUser(email: $email));
    }

    /**
     * @param  string  $email
     * @return $this
     */
    public function email(string $email): static
    {
        return $this->emailAddress($email);
    }

    /**
     * @param  MailMessage|callable  $content
     * @return $this
     */
    public function content(MailMessage|callable $content): static
    {
        if (is_callable($content)) {
            $content = $content($this->getUser());
        }

        $this->content = $content;

        return $this;
    }

    /**
     * @param  string|null  $subject
     * @return $this
     */
    public function subject(?string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param  string|null  $body
     * @return $this
     */
    public function body(?string $body): static
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param  string|null  $footer
     * @return $this
     */
    public function footer(?string $footer): static
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * @param  string|null  $message
     * @return $this
     */
    public function actionMessage(?string $message): static
    {
        $this->action_message = $message;

        return $this;
    }

    /**
     * @param  string  $url
     * @return $this
     */
    public function actionUrl(string $url): static
    {
        $this->action_url = $url;

        return $this;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        if ($this->content) {
            return $this->content;
        }

        return (new MailMessage())
                ->subject($this->getSubject())
                ->line($this->body)
                ->action($this->action_message, $this->action_url)
                ->line($this->footer);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            //
        ];
    }
}
