<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\DailyDeal\Block\Adminhtml\DailyDeal\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;
use Tigren\DailyDeal\Model\ResourceModel\DailyDeal\CollectionFactory;

/**
 * Class Information
 * @package Tigren\DailyDeal\Block\Adminhtml\DailyDeal\Edit\Tab
 */
class Information extends Generic
{
    /**
     * @var Store
     */
    protected $_store;
    protected $dailyDealCollectionFactory;
    /**
     * Information constructor.
     * @param Store $store
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param array $data
     */
    public function __construct(CollectionFactory $dailyDealCollectionFactory,Store $store, Context $context, Registry $registry, FormFactory $formFactory, array $data = [])
    {
        $this->_store = $store;
        $this->dailyDealCollectionFactory = $dailyDealCollectionFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return Information
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {

        $form = $this->_formFactory->create();
        $fieldset = $form->addFieldset(
            'information',
            ['legend' => __('General')]
        );
        $fieldset->addField('product_id', 'hidden', [
            'name' => 'product_id',
            'label' => __('Product Id'),
            'title' => __('Product Id')
        ]);

        $fieldset->addField('product_name', 'text', [
            'name' => 'product_name',
            'label' => __('Product'),
            'title' => __('Product'),
            'readonly' => true,
            'required' => true,
        ]);

        $fieldset->addField('original_price', 'note', [
            'label' => __('Original Price'),
            'text' => '0'
        ]);

        $fieldset->addField('product_qty', 'note', [
            'label' => __('Product Qty'),
            'text' => '0'
        ]);

        $fieldset->addField('status', 'select', [
            'name' => 'status',
            'label' => __('Status'),
            'title' => __('Status'),
            'required' => true,
            'options' => [
                '1' => __('Active'),
                '0' => __('Inactive')
            ]
        ]);

        $fieldset->addField('is_featured', 'select', [
            'name' => 'is_featured',
            'label' => __('Is Featured'),
            'title' => __('Is Featured'),
            'options' => [
                '1' => __('Yes'),
                '0' => __('No')
            ],
            'note' => __('If yes, this deal will be shown on Feature Deal Slider')
        ]);

        $fieldset->addField('deal_price', 'text', [
            'name' => 'deal_price',
            'label' => __('Deal Price'),
            'title' => __('Deal Price'),
            'required' => true,
        ]);

        $fieldset->addField('discount', 'note', [
            'label' => __('Discount'),
            'text' => '0'
        ]);

        $fieldset->addField('deal_qty', 'text', [
            'name' => 'deal_qty',
            'label' => __('Deal Qty'),
            'title' => __('Deal Qty'),
            'class' => 'validate-number validate-deal-qty',
            'required' => true,
            'note' => 'Leave this box blank (zero) if you don\'t want to leave a limit for the deal quantity.'
        ]);

        $fieldset->addField('sale_qty_label', 'note', [
            'name' => 'sale_qty_label',
            'label' => __('Qty of sold items'),
            'title' => __('Qty of sold items'),
            'text' => '0'
        ]);
        $fieldset->addField(
            'store_id',
            'multiselect',
            [
                'name' => 'store_id',
                'label' => __('Store '),
                'title' => __('Store'),
                'class' => 'store',
                'required' => true,
                'values' =>
                    $this->_store->getStoreValuesForForm(false, true)

            ]
        );

        $fieldset->addField('start_time', 'date', [
            'name' => 'start_time',
            'label' => __('Date From'),
            'id' => 'start_time',
            'title' => __('Date From'),
            'date_format' => 'yyyy-MM-dd',
            'time_format' => 'hh:mm:ss',
            'required' => true
        ]);

        $fieldset->addField('end_time', 'date', [
            'name' => 'end_time',
            'label' => __('Date To'),
            'id' => 'end_time',
            'title' => __('Date To'),
            'date_format' => 'yyyy-MM-dd',
            'time_format' => 'hh:mm:ss',
            'required' => true
        ]);
        $id = $this->getRequest()->getParam('daily_deal_id');
        if($id){
            $deal =  $this->dailyDealCollectionFactory->create()->addFieldToFilter('daily_deal_id',['eq' => $id])->getFirstItem();
            $form->setValues($deal->getData());
            $this->setForm($form);
        }
        return parent::_prepareForm();
    }
}
