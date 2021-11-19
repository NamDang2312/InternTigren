<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\DailyDeal\Controller\Adminhtml\Deal;

use Exception;
use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use RuntimeException;
use Tigren\DailyDeal\Model\DailyDealFactory;


/**
 * Class Save
 * @package Tigren\DailyDeal\Controller\Adminhtml\Deal
 */
class Save extends Action
{
    /**
     * @var DailyDeal
     */
    protected $uiDailyDealModel;


    /**
     * Save constructor.
     * @param Action\Context $context
     * @param DailyDeal $uiDailyDealModel
     */
    public function __construct(
        Action\Context $context,
        DailyDealFactory $uiDailyDealModel
    )
    {
        parent::__construct($context);
        $this->uiDailyDealModel = $uiDailyDealModel;


    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPost();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $deal = [];
            $deal['product_id'] = $data['product_id'];
            $deal['product_name'] = $data['product_name'];
            $deal['status'] = $data['status'];
            $deal['is_featured'] = $data['is_featured'];
            $deal['deal_price'] = $data['deal_price'];
            $deal['deal_qty'] = $data['deal_qty'];
            $deal['start_time'] = $data['start_time'];
            $deal['end_time'] = $data['end_time'];
            $store = implode(",", $data['store_id']);
            $deal['store_id'] = $store;
            $id = $this->getRequest()->getParam('daily_deal_id');
            $dailyDealFactory = $this->uiDailyDealModel->create();
            if ($id) {
                $dailyDealFactory->load($id);
            }

            $dailyDealFactory->addData($deal);
            try {
                $dailyDealFactory->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}
