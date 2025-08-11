# [Mailjet](https://www.mailjet.com/) (Sinch) webhook handler for [WHEP](https://github.com/Erwane/whep-mailjet) project

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![codecov](https://codecov.io/gh/Erwane/whep-mailjet/branch/1.x/graph/badge.svg?token=5MUECVAIKD)](https://codecov.io/gh/Erwane/whep-mailjet)
[![Build Status](https://github.com/Erwane/whep-mailjet/actions/workflows/ci.yml/badge.svg?branch=1.x)](https://github.com/Erwane/whep-mailjet/actions)
[![Packagist Downloads](https://img.shields.io/packagist/dt/Erwane/whep-mailjet)](https://packagist.org/packages/Erwane/whep-mailjet)
[![Packagist Version](https://img.shields.io/packagist/v/Erwane/whep-mailjet)](https://packagist.org/packages/Erwane/whep-mailjet)

Webhook handler for [Mailjet](https://www.mailjet.com/) (Sinch) emailing provider.

## Usage

```shell
composer require erwane/whep-mailjet
```

```php
use WHEP\Exception\IpException;  
use WHEP\Exception\ProviderException;  
use WHEP\Factory;  

try {
    $provider = Factory::provider('mailjet', [
        'client_ip' => $_SERVER['REMOTE_ADDR'] ?? null, // Use method from your framework to get the ServerRequest client ip.
        'callbacks' => [
            ProviderInterface::EVENT_BLOCKED => [$this, 'callbackInvalidate'],
            ProviderInterface::EVENT_BOUNCE_QUOTA => [$this, 'callbackUnsub'],
        ],
    ]);

    // process the data.
    $provider->process($webhookData);
    
    // Data available from provider getters.
    $recipient = $provider->getRecipient();
    
    // Launch callbacks
    $provider->callback();
} catch (IpException $e) {
    // log ?
} catch (ProviderException $e) {
    // log ?
}
```

See [WHEP Client README](https://github.com/Erwane/whep-client) for events and getters.
