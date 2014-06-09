# Install
```sh
composer require rixxi/mail-message-template
```

# Configure
```neon
extensions:
  rixxiMailMessageTemplate: Rixxi\Mail\DI\MessageTemplateExtension
```

# Use

## Template

Create template with subject, body and html body. All parts are optional.

```latte
{subject}Welcome to our site {$user->name}{/subject}

{body}
Oh how we are so grateful {$user->name} that you decided to join our awesome service.

Sincerly,
yours CEO
Only Man in the Company
{/body}

{body html} {* text is default *}
<marquee>Oh how we are so grateful {$user->name} that you decided to join our awesome service.<marquee>

<p>
	Sincerly,<br />
	yours <strong>CEO</strong><br />
	Only Man in the Company
</p>
{/body}
```

# Code

```php
$message = $messageFactory->createFromFile(__DIR__ . '/../mails/registration.latte', array(
	'user' => (object) array(
		'name' => 'Name Surname',
	),
));

// message will have set subject, body and its html alternative

// setup other stuff and send
$message->addTo($user->email);
$message->setFrom('example@example.com');

$this->sender->send($message);

\\ ...
```

Creating from file template will allow you to utilize `Nette\Mail\Message` auto-inlining of template content for html body.
You can alternatively use `createFromString` for creating message from string.
