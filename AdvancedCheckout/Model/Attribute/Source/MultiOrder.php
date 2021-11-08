<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Model\Attribute\Source;

/**
 * Class MultiOrder
 * @package Tigren\AdvancedCheckout\Model\Attribute\Source
 */
class MultiOrder extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var
     */
    protected $_options;

    /**
     * getAllOptions
     *
     * @return array
     */

    public function toOptionArray()
    {
        return array(
            array('value' => '1', 'label' => __('Yes')),
            array('value' => '0', 'label' => __('No'))
         );
     }

    /**
     * @return array|array[]
     */
    public function getAllOptions()
    {
        return $this->toOptionArray();
    }
}
