<?php
/**
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2020 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\DailyDeal\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Tigren\DailyDeal\Model\DailyDeal;
use Tigren\DailyDeal\Model\ResourceModel\DailyDeal\CollectionFactory;
use Magento\Framework\App\Helper\Context;

/**
 * Class Data
 * @package Tigren\DailyDeal\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @var CollectionFactory
     */
    protected $dealCollectionFactory;
    /**
     * @var DailyDeal
     */
    protected $dealModel;

    /**
     * Data constructor.
     * @param CollectionFactory $dealCollectionFactory
     * @param DailyDeal $dailyDealModel
     * @param Context $context
     */
    public function __construct(
        CollectionFactory $dealCollectionFactory,
        DailyDeal $dailyDealModel,
        Context $context)
    {
        parent::__construct($context);
        $this->dealCollectionFactory = $dealCollectionFactory;
        $this->dealModel = $dailyDealModel;
    }

    /**
     * @param $productId
     * @return string|null
     */
    public function getStatusDeal($productId)
    {
        if ($productId) {
            $dealCollection = $this->dealCollectionFactory->create()->addFieldToFilter('product_id', $productId)->getFirstItem();
            $startTime = strtotime($dealCollection->getStartTime());
            $endTime = strtotime($dealCollection->getEndTime());
            $now = time();
            $dealQty = (int)$dealCollection->getDealQty();
            $sold = (int)$dealCollection->getSold();
            $status = $dealCollection->getStatus();
            if ($status == 1) {
                if ($endTime > $now && $startTime < $now) {
                    if ($dealQty > $sold) {
                        return 'Deals in progress';
                    } else {
                        return 'Out of stock';
                    }
                } else if ($startTime > $now) {
                    return 'Up Comming';
                }
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * @param $productId
     * @return null|mixed
     */
    public function getCountdown($productId)
    {
        if ($productId) {
            $dealCollection = $this->dealCollectionFactory->create()->addFieldToFilter('product_id', $productId)->getFirstItem();
            $startTime = strtotime($dealCollection->getStartTime());
            $endTime = strtotime($dealCollection->getEndTime());
            $now = time();
            $dealQty = (int)$dealCollection->getDealQty();
            $sold = (int)$dealCollection->getSold();
            $status = $dealCollection->getStatus();
            if ($status == 1) {
                if ($endTime > $now && $startTime < $now) {
                    if ($dealQty > $sold) {
                        return $dealCollection->getEndTime();
                    } else {
                        return null;
                    }
                } else if ($startTime > $now) {
                    return $dealCollection->getStartTime();
                }
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

}
