<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\DailyDeal\Controller\Adminhtml\Deal;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Tigren\DailyDeal\Model\DailyDeal;

/**
 * Class Delete
 * @package Tigren\Rule\Controller\Adminhtml\Rule
 */
class Delete extends Action
{
    /**
     * @var
     */
    protected $modelGroup;

    /**
     * Delete constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context
    )
    {
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Tigren_DailyDeal::deal_delete');
    }

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('daily_deal_id');
        if ($id) {
            if (!($deal = $this->_objectManager->create(DailyDeal::class)->load($id))) {
                $this->messageManager->addError(__('Unable to proceed. Please, try again.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/index', ['_current' => true]);
            }
            try {
                $deal->delete();
                $this->messageManager->addSuccess(__('Your deal has been deleted !'));
            } catch (Exception $e) {
                $this->messageManager->addError(__('Error while trying to delete deal: '));
            }
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }
    }
}
