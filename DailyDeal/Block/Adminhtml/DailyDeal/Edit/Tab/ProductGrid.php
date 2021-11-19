<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\DailyDeal\Block\Adminhtml\DailyDeal\Edit\Tab;

use Exception;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory ;
use Magento\Framework\Exception\LocalizedException;
use Tigren\DailyDeal\Model\ResourceModel\DailyDeal\CollectionFactory as DealCollectionFactory;
/**
 * Class ProductGrid
 * @package Tigren\DailyDeal\Block\Adminhtml\DailyDeal\Edit\Tab
 */
class ProductGrid extends Extended
{
    /**
     * @var CollectionFactory
     */
    protected $productCollection;
    protected $dealCollection;
    /**
     * Grid constructor.
     * @param Context $context
     * @param Data $backendHelper
     * @param \ViMagento\HelloWorld\Model\ResourceModel\Post\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        CollectionFactory $productCollectionFactory,
        DealCollectionFactory $dealCollectionFactory,
        array $data = []
    )
    {
        $this->dealCollection = $dealCollectionFactory;
        $this->productCollection = $productCollectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return ProductGrid
     * @throws LocalizedException
     */
    protected function _prepareCollection()
    {
        $deal = $this->dealCollection->create()->addFieldToSelect('product_id')->getData();
        $collection = $this->productCollection->create()
            ->addAttributeToSelect('name');
        $collection->addAttributeToSelect('sku');
        $collection->addAttributeToSelect('barcode_qty');
        $collection->addAttributeToSelect('price');
        $collection->joinField('quantity', 'cataloginventory_stock_item', 'qty', 'product_id=entity_id');
//       Filter the products already in the deal
//        $collection->addFieldToFilter('entity_id',['nin'=>[$deal]]);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return $this
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'ids',
            [
                'type' => 'radio',
                'html_name' => 'products_id',

                'align' => 'center',
                'index' => 'entity_id',
                'header_css_class' => 'col-select',
                'column_css_class' => 'col-select'
            ]
        );
        $this->addColumn('entity_id', [
            'header' => __('Product ID'),
            'type' => 'number',
            'index' => 'entity_id',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
        ]);
        $this->addColumn('name', [
            'header' => __('Name'),
            'index' => 'name',
            'type' => 'text',
            'sortable' => true
        ]);
        $this->addColumn('sku', [
            'header' => __('Sku'),
            'index' => 'sku',
            'type' => 'text',
            'sortable' => true
        ]);
        $this->addColumn('price', [
            'header' => __('Price'),
            'index' => 'price',
            'type' => 'number',
            'sortable' => true
        ]);
        $this->addColumn('quantity', [
            'header' => ('Quantity'),
            'index' => 'quantity',
            'type' => 'number',
            'sortable' => true
        ]);

        return $this;
    }
}
