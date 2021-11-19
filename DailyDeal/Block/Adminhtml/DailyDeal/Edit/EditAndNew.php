<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\DailyDeal\Block\Adminhtml\DailyDeal\Edit;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Tabs;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Registry;

/**
 * Class EditAndNew
 * @package Tigren\DailyDeal\Block\Adminhtml\DailyDeal\Edit
 */
class EditAndNew extends Tabs
{
    /**
     * EditAndNew constructor.
     * @param Context $context
     * @param EncoderInterface $jsonEncoder
     * @param Session $authSession
     * @param Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        Context $context,
        EncoderInterface $jsonEncoder,
        Session $authSession,
        Registry $coreRegistry,
        array $data = []
    )
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $jsonEncoder, $authSession, $data);
    }

    /**
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('deal_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Daily Deal'));
    }

    /**
     * @return EditAndNew
     * @throws LocalizedException
     */
    protected function _prepareLayout()
    {

        $this->addTab(
            'product_grid',
            [
                'label' => __('Product'),
                'content' => $this->getLayout()->createBlock(
                    'Tigren\DailyDeal\Block\Adminhtml\DailyDeal\Edit\Tab\ProductGrid'
                )->toHtml(),
                'active' => true
            ]
        );
        $this->addTab(
            'information',
            [
                'label' => __('Infomation'),
                'content' => $this->getLayout()->createBlock(
                    'Tigren\DailyDeal\Block\Adminhtml\DailyDeal\Edit\Tab\Information'
                )->toHtml(),

            ]
        );
        return parent::_prepareLayout();
    }
}
