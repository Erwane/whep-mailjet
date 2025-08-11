<?php
/**
 * This file is part of WHEP library
 *
 * @copyright   Copyright (c) Erwane BRETON
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */
declare(strict_types=1);

namespace WHEP\Provider;

use WHEP\AbstractProvider;
use WHEP\ProviderInterface;

/**
 * Mailjet provider.
 *
 * @link https://www.mailjet.com/
 */
class Mailjet extends AbstractProvider
{
    protected $_typesMap = [
        'sent' => ProviderInterface::EVENT_SENT,
        'blocked' => ProviderInterface::EVENT_BLOCKED,
        'bounce' => ProviderInterface::EVENT_BOUNCE_SOFT,
        'open' => ProviderInterface::EVENT_OPENED,
        'click' => ProviderInterface::EVENT_CLICK,
        'unsub' => ProviderInterface::EVENT_UNSUB,
        'spam' => ProviderInterface::EVENT_ABUSE,
    ];

    protected $_allowedIpAndNetwork = [
        // '141.193.32.0/23', // Mailgun
        // '143.55.236.0/22', // Mailgun
        // '161.38.204.0/22', // Mailgun
        // '198.244.60.0/22', // Mailgun
        // '204.220.160.0/22', // Mailgun
        // '204.220.164.0/24', // Mailgun
        // '204.220.177.0/24', // Mailgun
        // '204.221.12.0/24', // Mailgun
        '45.14.148.0/24', // Mailjet
        '45.14.151.0/24', // Mailjet
        '87.253.232.0/21', // Mailjet
        '185.211.120.0/22', // Mailjet
        '185.189.236.0/22', // Mailjet
        '185.250.236.0/22', // Mailjet
    ];

    /**
     * @inheritDoc
     */
    protected function _load(array $data): void
    {
        parent::_load($data);

        $event = $data['event'] ?? null;

        // Type
        $this->_type = $this->_typesMap[$event] ?? ProviderInterface::EVENT_ERROR;

        $this->_recipient = $data['email'] ?? null;

        $this->_smtp = $data['smtp_reply'] ?? null;
        $this->_details = $data['error'] ?? null;

        if ($this->_type === ProviderInterface::EVENT_CLICK) {
            $this->_url = $data['url'] ?? null;
        }

        if ($event === 'bounce') {
            $hardBounce = $data['hard_bounce'] ?? null;
            $this->_type = $hardBounce ? ProviderInterface::EVENT_BOUNCE_HARD : ProviderInterface::EVENT_BOUNCE_SOFT;
        }

        $this->_raw = $data;
    }
}
