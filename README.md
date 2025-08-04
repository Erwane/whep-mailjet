# [Mailjet](https://www.mailjet.com/) (Sinch) webhook handler for [WHEP](https://github.com/Erwane/whep-mailjet) project

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![codecov](https://codecov.io/gh/Erwane/whep-mailjet/branch/2.x/graph/badge.svg?token=5MUECVAIKD)](https://codecov.io/gh/Erwane/whep-mailjet)
[![Build Status](https://github.com/Erwane/whep-mailjet/actions/workflows/ci.yml/badge.svg?branch=2.x)](https://github.com/Erwane/whep-mailjet/actions)
[![Packagist Downloads](https://img.shields.io/packagist/dt/Erwane/whep-mailjet)](https://packagist.org/packages/Erwane/whep-mailjet)
[![Packagist Version](https://img.shields.io/packagist/v/Erwane/whep-mailjet)](https://packagist.org/packages/Erwane/whep-mailjet)

Webhook handler for [Mailjet](https://www.mailjet.com/) (Sinch) emailing provider.

## Usage

```shell
composer require erwane/whep-mailjet
```

```php
use WHEP\Client;
use WHEP\WebhookProviderException;

$provider = Client::getProvider('mailjet', [
    'callbacks' => [
        ProviderInterface::EVENT_BLOCKED => [$this, 'callbackInvalidate'],
        ProviderInterface::EVENT_BOUNCE_QUOTA => [$this, 'callbackUnsub'],
    ],
]);

try {
    // process the data.
    $provider->process($webhookData);
    
    // Data available from provider getters.
    $email = $provider->getRecipient();
    
    // Launch callbacks
    $provider->callback();
} catch (WebhookProviderException $e) {
    // log ?
}
```

See [WHEP Client README](https://github.com/Erwane/whep-client) for events and getters.
