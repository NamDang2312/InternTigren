<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Model\Attribute\Frontend;

/**
 * Class MultiOrder
 * @package Tigren\AdvancedCheckout\Model\Attribute\Frontend
 */
class MultiOrder extends \Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend
{
    /**
     * @param \Magento\Framework\DataObject $object
     * @return string
     */
    public function getValue(\Magento\Framework\DataObject $object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
        return "<b>$value</b>";
    }
}
