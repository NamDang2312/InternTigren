<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\DailyDeal\Plugin;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Tigren\DailyDeal\Model\ResourceModel\DailyDeal\CollectionFactory as DealCollectionFactory;

/**
 * Class HideButton
 * @package Tigren\Rule\Plugin
 */
class ChangePrice
{
    /**
     * @var CollectionFactory
     */
    protected $_productCollectionFactory;


    /**
     * @var DealCollectionFactory
     */
    protected $dealCollection;


    /**
     * ChangePrice constructor.
     * @param CollectionFactory $productCollectionFactory
     * @param DealCollectionFactory $dealCollectionFactory
     */
    public function __construct(
        CollectionFactory $productCollectionFactory,
        DealCollectionFactory $dealCollectionFactory
    )
    {
        $this->dealCollection = $dealCollectionFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
    }


    /**
     * @param Product $subject
     * @param $result
     * @return float|mixed
     */
    public function afterGetSpecialPrice(Product $subject, $result)
    {
        $deal = $this->dealCollection->create()->addFieldToFilter('product_id', ['eq' => $subject->getId()])->getFirstItem();
        if ($deal) {
            $now = time();
            $endTime = strtotime($deal->getEndTime());
            $startTime = strtotime($deal->getStartTime());
            $dealQty = $deal->getDealQty();
            if ((int)$dealQty > (int)$deal->getSold() && (int)$deal->getStatus() == 1 && $endTime - $now > 0 && $startTime - $now < 0) {
                $result = $subject->getPrice() - $deal->getDealPrice();
            }
        }
        return $result;
    }
}
