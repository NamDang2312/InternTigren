<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\DailyDeal\Plugin;

use Exception;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\OrderFactory;
use Tigren\DailyDeal\Model\DailyDeal;
use Tigren\DailyDeal\Model\ResourceModel\DailyDeal\CollectionFactory;

/**
 * Class PlaceAfterPlugin
 * @package Tigren\DailyDeal\Plugin
 */
class PlaceAfterPlugin
{
    /**
     * @var DailyDeal
     */
    protected $_dealModel;
    /**
     * @var CollectionFactory
     */
    protected $_dealCollection;
    /**
     * @var OrderRepositoryInterface
     */
    protected $_orderFactory;

    /**
     * PlaceAfterPlugin constructor.
     * @param CollectionFactory $dealCollectionFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param DailyDeal $dealModel
     */
    public function __construct(
        CollectionFactory $dealCollectionFactory,
        OrderRepositoryInterface $orderRepository,
        DailyDeal $dealModel
    )
    {
        $this->_dealCollection = $dealCollectionFactory;
        $this->_orderFactory = $orderRepository;
        $this->_dealModel = $dealModel;
    }

    /**
     * @param OrderManagementInterface $orderManagementInterface
     * @param $order
     * @return mixed
     * @throws Exception
     */
    public function afterPlace(OrderManagementInterface $orderManagementInterface, $order)
    {
        $orderId = $order->getId();
        if ($orderId) {
            $orderModel = $this->_orderFactory->get($orderId);
            $orderItems = $orderModel->getAllVisibleItems();
            foreach ($orderItems as $item) {
                $dealCollection = $this->_dealCollection->create();
                $deal = $dealCollection->addFieldToFilter('product_id', $item->getProductId())->getFirstItem();
                if ($deal) {
                    $now = time();
                    $endTime = strtotime($deal->getEndTime());
                    $startTime = strtotime($deal->getStartTime());
                    $dealQty = $deal->getDealQty();
                    if ((int)$dealQty > (int)$deal->getSold() && (int)$deal->getStatus() == 1 && $endTime > $now && $startTime < $now) {
                        $this->_dealModel->load($deal->getDailyDealId());
                        $deal->setData('sold', (int)$deal->getSold() + (int)$item->getQtyOrdered());
                        $this->_dealModel->setData($deal->getData());
                        $this->_dealModel->save();
                    }
                }
            }
        }
        return $order;
    }
}
