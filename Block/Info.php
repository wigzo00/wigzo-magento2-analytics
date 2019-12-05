<?php
namespace Wigzo\Service\Block;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Info extends \Magento\Backend\Block\Widget implements \Magento\Framework\Data\Form\Element\Renderer\RendererInterface {

    protected $registry;
    protected $context;

    /**
    * @param \Magento\Backend\Block\Template\Context $context
    * @param \Magento\Framework\Registry $registry
    * @param array $data
    */
   public function __construct(
       \Magento\Backend\Block\Template\Context $context,
       \Magento\Framework\Registry $registry,
       array $data = []
   ) {
       $this->registry = $registry;
       $this->context = $context;
       parent::__construct($context, $data);
   }

    public function render(AbstractElement $element)
    {
        $this->setElement($element);
        $html = '<div style="background:url(\'https://www.wigzo.com/wp-content/uploads/2018/12/wigzo-logo.png\') no-repeat scroll 15px center #FFFFFF;background-size:160px;margin-bottom:10px;padding:10px 5px 5px 200px;">
                    <h1>The Best Platform For Growing Your Online Store</h1>
                    <p>Wigzo helps you generate more revenue, cultivate loyal customers and optimize product strategy.</p>
                    <br />
                    <table width="500px" border="0">
                        <tr>
                            <td>Questions, comments, need help? Send us an email.</td>
                            <td><a href="mailto:support@wigzo.com">support@wigzo.com</a></td>
                        </tr>
                        <tr>
                            <td height="30">Visit our website:</td>
                            <td><a href="https://wigzo.com" target="_blank">wigzo.com</a></td>
                        </tr>
                    </table>
                </div>';

        return $html;
    }
}
