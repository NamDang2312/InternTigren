<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\DailyDeal\Block\Product;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\SessionException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Api\OrderRepositoryInterface;
use Tigren\DailyDeal\Model\ResourceModel\DailyDeal\CollectionFactory;
use Magento\Framework\Registry;

/**
 * Class Index
 * @package Tigren\Rule\Block
 */
class Countdown extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $dealCollectionfactory;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionfactory;
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;
    /**
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * Countdown constructor.
     * @param Context $context
     * @param CollectionFactory $deaCollectionFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        CollectionFactory $deaCollectionFactory,
        OrderRepositoryInterface $orderRepository,
        Registry $registry
    )
    {
        $this->_coreRegistry = $registry;
        parent::__construct($context);
        $this->dealCollectionfactory = $deaCollectionFactory;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return \Magento\Framework\DataObject|null
     */
    public function getDeal()
    {
        $productId = $this->_coreRegistry->registry('product')->getEntityId();
        if($productId){
            $deal = $this->dealCollectionfactory->create()->addFieldToFilter('product_id', ['eq' => $productId])->getFirstItem();
            $now = time();
            $endTime = strtotime($deal->getEndTime());
            $startTime = strtotime($deal->getStartTime());
            $dealQty = $deal->getDealQty();
            if ((int)$dealQty > (int)$deal->getSold() && (int)$deal->getStatus() == 1 && $endTime - $now > 0 && $startTime - $now < 0) {
                return $deal;
            } else {
                return null;
            }
        }else{
            return null;
        }
    }
}
