<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Controller\Check;

use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class CheckAllowMultiOrder
 * @package Tigren\AdvancedCheckout\Controller\Check
 */
class CheckAllowMultiOrder extends Action
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
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * CheckAllowMultiOrder constructor.
     * @param Context $context
     * @param Json $json
     * @param JsonFactory $resultJsonFactory
     * @param CollectionFactory $productCollectionFactory
     * @param ProductRepository $productRepository
     */
    public function __construct(
        Context $context,
        Json $json,
        JsonFactory $resultJsonFactory,
        CollectionFactory $productCollectionFactory,
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
        $this->json = $json;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->productCollection = $productCollectionFactory;
        return parent::__construct($context);
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Json|ResultInterface
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $response = $this->getRequest()->getParams();
        $idProduct = $response['idProduct'];
        $product = $this->productRepository->getById($idProduct);
        $attribute = $product->getCustomAttribute('Multi_order')->getValue();
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData(['MultiOrder' => $attribute]);
    }
}
