<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\DailyDeal\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class DailyDeal
 * @package Tigren\DailyDeal\Model
 */
class DailyDeal extends AbstractModel implements IdentityInterface
{
    /**
     *
     */
    const CACHE_TAG = 'daily_deal';

    /**
     * @var string
     */
    protected $_cacheTag = 'daily_deal';

    /**
     * @var string
     */
    protected $_eventPrefix = 'daily_deal';

    /**
     *
     */
    protected function _construct()
    {
        $this->_init('Tigren\DailyDeal\Model\ResourceModel\DailyDeal');
    }

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
