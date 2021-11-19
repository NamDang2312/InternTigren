<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\DailyDeal\Model\ResourceModel\DailyDeal;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Tigren\DailyDeal\Model\ResourceModel\DailyDeal
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'daily_deal_id';
    /**
     * @var string
     */
    protected $_eventPrefix = 'daily_deal_collection';
    /**
     * @var string
     */
    protected $_eventObject = 'daily_deal_collection';
//

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Tigren\DailyDeal\Model\DailyDeal', 'Tigren\DailyDeal\Model\ResourceModel\DailyDeal');
    }
}
