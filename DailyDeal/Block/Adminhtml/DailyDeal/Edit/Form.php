<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\DailyDeal\Block\Adminhtml\DailyDeal\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

/**
 * Class Form
 * @package Tigren\DailyDeal\Block\Adminhtml\DailyDeal\Edit
 */
class Form extends Generic
{
    /**
     * @return Form
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            ['data' => [
                'id' => 'edit_form',
                'enctype' => 'multipart/form-data',
                'action' =>$this->getUrl('*/*/save', ['daily_deal_id' => $this->getRequest()->getParam('daily_deal_id')]),
                'method' => 'post'
            ]
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
