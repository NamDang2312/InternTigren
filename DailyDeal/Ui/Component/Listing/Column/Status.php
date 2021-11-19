<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

namespace Tigren\DailyDeal\Ui\Component\Listing\Column;


use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Status
 * @package Tigren\DailyDeal\Ui\Component\Listing\Column
 */
class Status extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param UrlInterface $urlBuilder
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        UrlInterface $urlBuilder,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item[$this->getData('name')])) {
                    $now = time();
                    $endTime = strtotime($item['end_time']);
                    $startTime = strtotime($item['start_time']);
                    if ($item['status'] == 1) {
                        if ($endTime > $now && $startTime < $now) {
                            if ($item['deal_qty'] > $item['sold']) {
                                $item[$this->getData('name')] = 'Running';
                            } else {
                                $item[$this->getData('name')] = 'Out of stock';
                            }
                        } else if ($endTime < $now) {
                            $item[$this->getData('name')] = 'Out of Time';
                        } else if ($startTime > $now) {
                            $item[$this->getData('name')] = 'Up Comming';
                        }
                    } else {
                        $item[$this->getData('name')] = 'In Active';
                    }
                }
            }
        }
        return $dataSource;
    }
}
