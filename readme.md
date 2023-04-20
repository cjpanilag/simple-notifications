# Simple Notifications

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

Simplified notifications for AWS SNS, FCM Push Notifications, emails, and more.

## Installation

Via Composer

``` bash
$ composer require cjpanilag/simple-notifications
$ php artisan migrate
```

After migration, `simple-notification` will generate two (2) tables namely `fcm_tokens` & `simple_devices`. Make sure to remove any conflicting table or attribute in your root project.

## Usage

### AWS SNS

**User Model Configuration**

```php
use Cjpanilag\SimpleNotifications\Traits\HasSnsNotifiableTrait;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, HasSnsNotifiableTrait;
    
    /**
     * Overridden method (optional)
     * By default, `SnsNoticiableTrait` will look
     * for the specific attribute in your model:
     *       `phone`,
     *       `phone_number`,
     *       `full_phone`
     * 
     * @override
     * @param $notification
     * @return string|null
     */
    public function routeNotificationForSns($notification): string|null
    {
        // model attribute
        return $this->specific_mobile_number_attribute;
    }
}
```

*Note*: In order to let your `Notification` know which phone you are sending to, the channel will look for the `phone`, `phone_number` or `full_phone` attribute of the `Notifiable` model.

**Sending SMS to user**

```php
// Sending SMS to a User model...
$user = User::first();

simpleNotifications()->sns()
            ->user($user)
            ->content('Message here...')
            ->execute();

// Sending SMS to a specific phone...
simpleNotifications()->sns()
            ->mobile('+639123456789')
            ->content('Message here...')
            ->execute();

```

**Sending SMS using content callable**

```php 
// Sending SMS to a User model...
$user = User::first();

simpleNotifications()->sns()
            ->user($user)
            ->content(fn($user) => "Welcome $user->name") // passing notifiable
            ->execute();

// Sending SMS to a specific phone...
simpleNotifications()->sns()
            ->mobile('+639123456789')
            ->content(fn($user) => "Welcome $user->name") // passing notifiable
            ->execute();
```

**Sending SMS using `SnsMessage` as content**

```php
// Sending SMS to a User model...
$user = User::first();

simpleNotifications()->sns()->user($user)->content(function ($user) {
    $snsMessage = new SnsMessage('message here...');

    $snsMessage->sender('FIN-PAY');
    $snsMessage->transactional(true);

    return $snsMessage;
})->execute();

// Sending SMS to a specific phone...
simpleNotifications()->sns()->mobile('+639123456789')->content(function ($user) {
    $snsMessage = new SnsMessage('message here...');

    $snsMessage->sender('FIN-PAY');
    $snsMessage->transactional(true);

    return $snsMessage;
})->execute();
```

Available Methods

| method  | parameter                        | return type | description                            |
|---------|----------------------------------|-------------|----------------------------------------|
| user    | `Model`                          | `static`    | assigning user.                        |
| content | `SnsMessage` `string` `callable` | `static`    | can be message or a callable function. |
| mobile  | `string`                         | `static`    | replacement for `user` methods.        |
| execute | none                             | `void`      | will execute the sending.              |


*Note*: `user` or `mobile` method should not be used _at the same time_.

Example:

```php
simpleNotifications()->sns()
            ->user($user)               // User already have <mobile number attribute>...
            ->mobile('+63923456789')    // Will conflict with User mobile number attribute...
            ->content('Message here...')
            ->execute();
```

### SES MAIL

**User Model Configuration**

```php
use Cjpanilag\SimpleNotifications\Traits\HasMailNotifiableTrait;

class Model extends Authenticatable
{
    use HasApiTokens, HasFactory, HasMailNotifiableTrait;
    
    /**
     * @param $notification
     * @return array|string|null
     */
    public function routeNotificationForMail($notification): array|string|null
    {
        // Define a specific <email attribute>
        return $this->email_address;
    }
}
```

*Note*: By default, `Notification` will send email to User's `email` attribute.

**Sending Mail to user**

```php
// Sending mail to a User model...
$user = User::first();

simpleNotifications()->mail()
    ->user($user)
    ->subject('Test Subject 123')
    ->body('test body')
    ->footer('test footer')
    ->actionMessage('PUSH ME!')
    ->actionUrl('http://localhost')
    ->execute();

// Sending mail to a specific email address...
simpleNotifications()->mail()
    ->emailAddress('testemail123@gmail.com')
    ->subject('Test Subject 123')
    ->body('test body')
    ->footer('test footer')
    ->actionMessage('PUSH ME!')
    ->actionUrl('http://localhost')
    ->execute();
```

**Sending Mail using `MailMessage` as content**

```php 
// Sending mail to a User model...
$user = User::first();

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

// Sending mail to a specific email address...
```php 
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
```

**Sending Mail using `MailMessage` with customized `view` as content**

```php 
// Sending mail to a specific email address...
simpleNotifications()->mail()->emailAddress('testemail123@gmail.com')->content(function ($user) {
    $mailMessage = new MailMessage();
    
    $mailMessage->view('view.template');

    return $mailMessage;
})->execute();
```

Available Methods

| method        | parameter | return type | description                     |
|---------------|-----------|-------------|---------------------------------|
| user          | `Model`   | `static`    | notifiable.                     |
| subject       | `string`  | `static`    | email subject.                  |
| title         | `string`  | `static`    | email title.                    |
| footer        | `string`  | `static`    | email footer.                   |
| actionMessage | `string`  | `static`    | action message.                 |
| actionUrl     | `string`  | `static`    | action URL.                     |
| emailAddress  | `string`  | `static`    | replacement for `user` methods. |
| execute       | none      | `static`    | execute notification.           |


*Note*: `user` or `emailAddress` method should not be used _at the same time_.

Example:

```php 
$user = User::first();

simpleNotifications()->mail()
    ->user($user)                               // user has email attribute
    ->emailAddress('testemail123@gmail.com')    // conflict with email attribute
    ->subject('Test Subject 123')
    ->body('test body')
    ->footer('test footer')
    ->actionMessage('PUSH ME!')
    ->actionUrl('http://localhost')
    ->execute();
```

### FCM Notification

Make sure that you already run `artisan migrate` after installing this package.
FCM will use the `fcm_tokens` table and `simple_devices` table.

`simple_devices` table stores users' devices. Each device can have multiple FCM tokens.
`fcm_tokens` table stores the devices' FCM tokens.

**Simple Device API**

A route will be provided by this package. Check your project level `routes/api.php` for possible conflicts.

```
POST /api/device
```
body

| key            | description         |
|----------------|---------------------|
| device_id      | `required` `unique` |
| unique_id      | `required`          |
| brand          | nullable            |
| type           | nullable            |
| name           | nullable            |
| manufacturer   | nullable            |
| model          | nullable            |
| system_name    | nullable            |
| system_version | nullable            |
| version        | nullable            |
| active         | nullable            |

**FCM Token API**

A route will be provided by this package. Check your project level `routes/api.php` for possible conflicts.

```
POST /api/fcm-token
```

| key         | description |
|-------------|-------------|
| device_uuid | `required`  |
| token       | `required`  |

**Sending FCM Notification to user**

```php 
$user = User::first();

simpleNotifications()
    ->fcm()
    ->user($user)
    ->data([])
    ->title('Welcome Test')
    ->body('just test')
    ->execute();
```

**Sending FCM Notification using FCM Token**

```php 
simpleNotifications()
    ->fcm()
    ->token($token)
    ->data([])
    ->title('Welcome Test')
    ->body('just test')
    ->execute();
```

Available Methods

| method  | parameter | description          |
|---------|-----------|----------------------|
| user    | `Model`   | notifiable           |
| data    | `array`   | notification data    |
| title   | `string`  | notification title   |
| body    | `string`  | notification message |
| execute | none      | execute send         |

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email cjpanilag@gmail.com instead of using the issue tracker.

## Credits

- [Carl Jeffrie Panilag][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/cjpanilag/simple-notifications.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/cjpanilag/simple-notifications.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/cjpanilag/simple-notifications
[link-downloads]: https://packagist.org/packages/cjpanilag/simple-notifications
[link-author]: https://github.com/cjpanilag
[link-contributors]: ../../contributors
