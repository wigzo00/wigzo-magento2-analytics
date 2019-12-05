<?php
namespace Wigzo\Service\Model\Types;

use Wigzo\Service\Helper\Data;
use Magento\Newsletter\Model\ResourceModel\Subscriber\CollectionFactory;
use Wigzo\Service\Model\Types\SubscriberFactory;

class Subscribers {

    public $subscribers = array();
    private $pageNum;
    protected $helper;
    protected $collectionFactory;
    protected $subscriberFactory;

    /**
     * @param \Wigzo\Service\Helper\Data $helper
     * @param \Magento\Newsletter\Model\ResourceModel\Subscriber\CollectionFactory $collectionFactory
     * @param \Wigzo\Service\Model\Types\SubscriberFactory $subscriberFactory
     */
    public function __construct(
        Data $helper,
        CollectionFactory $collectionFactory,
        SubscriberFactory $subscriberFactory
    ) {
        $this->helper = $helper;
        $this->collectionFactory = $collectionFactory;
        $this->subscriberFactory = $subscriberFactory;
    }

    public function load($pageSize, $pageNum, $sortDir, $filterBy, $id)
    {
        $config = $this->helper->getConfig();
        $this->pageNum = $pageNum;
        if ($id) {
            $subscribers = $this->collectionFactory->create()
                ->addFieldToFilter('main_table.subscriber_id', $id);
        } else {
            $subscribers = $this->collectionFactory->create();
        }
        $subscribers->addFilter('store_id', 'store_id = '.$this->helper->getStore()->getStoreId(), 'string');
        $subscribers->setOrder('subscriber_id', $sortDir);
        $subscribers->setCurPage($pageNum);
        $subscribers->setPageSize($pageSize);

        if ($subscribers->getLastPageNumber() < $pageNum) {
            return $this;
        }

        foreach ($subscribers as $subscriber) {
            $model = $this->subscriberFactory->create();
            $wigzoSubscriber = $model->parse($subscriber);
            if ($wigzoSubscriber) {
                $this->subscribers[] = $wigzoSubscriber;
            }
        }

        return $this->subscribers;
    }
}
