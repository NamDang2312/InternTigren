<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Controller\Clear;

use Magento\Checkout\Model\Cart;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class ClearCart
 * @package Tigren\AdvancedCheckout\Controller\Clear
 */
class ClearCart extends Action
{
    /**
     * @var Cart
     */
    protected $_modelCart;
    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * ClearCart constructor.
     * @param CheckoutSession $checkoutSession
     * @param JsonFactory $resultJsonFactory
     * @param Context $context
     * @param Cart $modelCart
     */
    public function __construct(
        CheckoutSession $checkoutSession,
        JsonFactory $resultJsonFactory,
        Context $context,
        Cart $modelCart
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->checkoutSession = $checkoutSession;
        $this->_modelCart = $modelCart;
        return parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Json|ResultInterface
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $cart = $this->_modelCart;
        $quoteItems = $this->checkoutSession->getQuote()->getItemsCollection();
        foreach ($quoteItems as $item) {
            $cart->removeItem($item->getId())->save();
        }
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData(['a' => 'abc']);
    }
}
