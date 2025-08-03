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
