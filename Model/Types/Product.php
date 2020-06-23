<?php
namespace Wigzo\Service\Model\Types;
class Product {
    protected $helper;
    protected $objectManager;
    /**
     * @param \Wigzo\Service\Helper\Data $helper
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Wigzo\Service\Helper\Data $helper,
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        $this->objectManager = $objectManager;
        $this->helper = $helper;
    }
    public function parse($productId, $productAttributes) {
        $product = $this->objectManager->create('\Magento\Catalog\Model\Product')->load($productId);
        $parentProductImage = false;
        $this->product_id = $productId;
        $this->entity_id = $product->getData('entity_id');
        $this->entity_type_id = $product->getData('entity_type_id');
        $this->attribute_set_id = $product->getData('attribute_set_id');
        $this->type_id = $product->getData('type_id');
        $this->category_ids = $product->getCategoryIds();
        $parentProductIds = $this->objectManager->create('\Magento\ConfigurableProduct\Model\Product\Type\Configurable')
            ->getParentIdsByChild($productId);
        if($parentProductIds) {
            $this->parent_product_id = $parentProductIds[0];
            $parentProduct = $this->objectManager->create('\Magento\Catalog\Model\Product')->load($parentProductIds[0]);
	    $parentProductImage = $parentProduct->getImage();
	    $this->parent_json =   array(
                'price'=> $parentProduct->getData('price'),
                'product_id'=>  $parentProductIds[0],
                'created_at'=>  $parentProduct->getData('created_at'),
                'updated_at'=>  $parentProduct->getData('updated_at'),
                'name'=>  $parentProduct->getData('name'),
                'description'=>  $parentProduct->getData('description'),
                'sku'=>  $parentProduct->getData('sku')
            );
 
	}
        foreach ($productAttributes as $field => $usesSource) {
            try {
                $value = $product->getData($field);
                if (is_array($value) || is_object($value)) {
                    continue;
                }
                if ($field == 'image') {
                    if((!$value || $value == 'no_selection') && $parentProductImage) {
                        $value = $parentProductImage;
                    }
                    if(!is_array($value)) {
                        $imageUrl = $this->helper->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $value;
                    } else {
                        $imageUrl = null;
                    }
                    $this->$field = $imageUrl;
                    continue;
                }
                if ($usesSource) {
                    $option = $product->getAttributeText($field);
                    if ($value && empty($option) && $option != '0') {
                        continue;
                    }
                    if (is_array($option)) {
                        $value = implode(',', $option);
                    } else {
                        $value = $option;
                    }
                }
                if ($field == 'category_ids') {
                    continue;
                }
                $this->$field = $value;
            } catch (Exception $e) {
                continue;
            }
        }
        return $this;
    }
}
