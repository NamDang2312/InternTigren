<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Controller\Check;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Checkout\Model\Cart;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class CheckItemsCard
 * @package Tigren\AdvancedCheckout\Controller\Check
 */
class CheckItemsCard extends Action
{
    /**
     * @var Json
     */
    protected $json;
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;
    /**
     * @var CollectionFactory
     */
    protected $productCollection;
    /**
     * @var Cart
     */
    protected $cart;

    /**
     * CheckItemsCard constructor.
     * @param Context $context
     * @param Json $json
     * @param JsonFactory $resultJsonFactory
     * @param CollectionFactory $productCollectionFactory
     * @param Cart $cart
     */
    public function __construct(
        Context $context,
        Json $json,
        JsonFactory $resultJsonFactory,
        CollectionFactory $productCollectionFactory,
        Cart $cart
    ) {
        $this->cart = $cart;
        $this->json = $json;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->productCollection = $productCollectionFactory;
        return parent::__construct($context);
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Json|ResultInterface
     */
    public function execute()
    {
        $itemsQty = $this->cart->getQuote()->getItemsQty();
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData(['itemsQty' => $itemsQty]);
    }
}
