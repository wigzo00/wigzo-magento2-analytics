<?php
namespace Wigzo\Service\Block;
use Magento\Framework\Data\Form\Element\AbstractElement;

class SecretKey extends \Magento\Config\Block\System\Config\Form\Field {

    protected $storeManager;
    protected $helper;
    protected $context;

    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Wigzo\Service\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Wigzo\Service\Helper\Data $helper,
        array $data = []
    ) {
        $this->storeManager = $context->getStoreManager();
        $this->helper = $helper;
        $this->context = $context;
        parent::__construct($context, $data);
    }

    protected function _getElementHtml(AbstractElement $element) {
        $html = $element->getElementHtml();
        $config = $this->helper->getConfig();
        $token = $config['security_token'];
        $html .= trim($token);
        return $html;
    }
}
