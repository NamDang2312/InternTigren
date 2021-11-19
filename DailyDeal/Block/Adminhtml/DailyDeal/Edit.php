<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\DailyDeal\Block\Adminhtml\DailyDeal;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;
use Magento\Backend\Block\Widget\Context;

/**
 * Class Edit
 * @package Tigren\DailyDeal\Block\Adminhtml\DailyDeal
 */
class Edit extends Container
{
    /**
     * @var Registry|null
     */
    protected $_coreRegistry = null;

    /**
     * Edit constructor.
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     *
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Tigren_DailyDeal';
        $this->_controller = 'adminhtml_dailyDeal';
        parent::_construct();
        $this->buttonList->remove('delete');
        $this->buttonList->update('save', 'label', __('Save Deal'));
        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => ['button' => ['event' => 'save','target' => '#edit_form']],
                    'form-role' => 'save',
                ],'sort_order' => 90
            ]
        );
    }

}
