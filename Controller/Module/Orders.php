<?php
namespace Wigzo\Service\Controller\Module;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Wigzo\Service\Model\Types\OrdersFactory;
use Wigzo\Service\Helper\Data;

class Orders extends \Wigzo\Service\Controller\Module {

    protected $resultJsonFactory;
    protected $ordersFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Wigzo\Service\Model\Types\OrdersFactory $ordersFactory
     * @param \Wigzo\Service\Helper\Data $helper
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        OrdersFactory $ordersFactory,
        Data $helper
    ) {

        $this->resultJsonFactory = $resultJsonFactory;
        $this->ordersFactory = $ordersFactory;
        $this->helper = $helper;
        parent::__construct($context);
        parent::initParams();

    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $orders = $this->ordersFactory->create();

        if($this->isAuthorized() != true || $this->isEnabled() != true) {
            $result->setHttpResponseCode(\Magento\Framework\App\Response\Http::STATUS_CODE_401);
            $result->setData(['error' => 'Invalid security token or module disabled']);
            return $result;
        }

        $data = $orders->load(
            $this->pageSize,
            $this->pageNum,
            $this->startDate,
            $this->endDate,
            $this->sortDir,
            $this->filterField,
            $this->id
        );

        return $result->setData(['orders' => $data]);
    }
}
