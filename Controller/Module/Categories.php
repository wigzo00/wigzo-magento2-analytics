<?php
namespace Wigzo\Service\Controller\Module;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Wigzo\Service\Model\Types\CategoriesFactory;
use Wigzo\Service\Helper\Data;

class Categories extends \Wigzo\Service\Controller\Module {

    protected $resultJsonFactory;
    protected $categoriesFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Wigzo\Service\Model\Types\CategoriesFactory $categoriesFactory
     * @param \Wigzo\Service\Helper\Data $helper
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        CategoriesFactory $categoriesFactory,
        Data $helper
    ) {

        $this->resultJsonFactory = $resultJsonFactory;
        $this->categoriesFactory = $categoriesFactory;
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
        $categories = $this->categoriesFactory->create();

        if($this->isAuthorized() != true || $this->isEnabled() != true) {
            $result->setHttpResponseCode(\Magento\Framework\App\Response\Http::STATUS_CODE_401);
            $result->setData(['error' => 'Invalid security token or module disabled']);
            return $result;
        }

        $data = $categories->load(
            $this->pageSize,
            $this->pageNum,
            $this->startDate,
            $this->endDate,
            $this->sortDir,
            $this->filterField,
            $this->id
        );
        return $result->setData(['categories' => $data]);
    }
}
