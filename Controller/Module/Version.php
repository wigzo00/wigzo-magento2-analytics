<?php
namespace Wigzo\Service\Controller\Module;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\ProductMetadataInterfaceFactory;
use Wigzo\Service\Helper\Data;

class Version extends \Wigzo\Service\Controller\Module {

    protected $resultJsonFactory;
    protected $productMetadataInterfaceFactory;
    protected $helper;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Framework\App\ProductMetadataInterfaceFactory $productMetadataInterfaceFactory
     * @param \Wigzo\Service\Helper\Data $helper
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        ProductMetadataInterfaceFactory $productMetadataInterfaceFactory,
        Data $helper
    ) {

        $this->resultJsonFactory = $resultJsonFactory;
        $this->productMetadataInterfaceFactory = $productMetadataInterfaceFactory;
        $this->helper = $helper;
        parent::__construct($context);
        parent::initParams();

    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $result */
        $productMetadata = $this->productMetadataInterfaceFactory->create();

		    $result = $this->resultJsonFactory->create();
        $data = new \stdClass();
        $data->wigzoPluginVersion = (string) $this->helper->getVersion();
        $data->magentoVersion = (string) $productMetadata->getVersion();
        $data->magentoEdition = (string) $productMetadata->getEdition();
        $data->phpVersion = (string) phpversion();
        $data->moduleEnabled = $this->helper->getConfig()['enabled'];
        $data->apiVersion = "2.0";
        $data->memoryLimit = @ini_get('memory_limit');
        $data->maxExecutionTime = @ini_get('max_execution_time');
        return $result->setData($data);
    }
}
