<?php
namespace Wigzo\Service\Model\Types;

use Wigzo\Service\Helper\Data;
use Wigzo\Service\Model\Types\StoreFactory;

class Stores {

    public $stores = array();
    protected $helper;
    protected $storeFactory;
    private $pageNum;

    /**
     * @param \Wigzo\Service\Helper\Data $helper
     * @param \Wigzo\Service\Model\Types\StoreFactory $storeFactory
     */
    public function __construct(
        Data $helper,
        StoreFactory $storeFactory
    ) {
        $this->helper = $helper;
        $this->storeFactory = $storeFactory;
    }

    public function load($pageSize, $pageNum)
    {
        $config = $this->helper->getConfig();
        $this->pageNum = $pageNum;

        $stores = $this->helper->getStores();
        $stores = $this->helper->paginate($stores, $pageNum, $pageSize);

        foreach($stores as $store) {
            $wigzoStore = $this->storeFactory->create();
            $storeModel = $wigzoStore->parse($store);
            if ($storeModel) {
                $this->stores[] = $storeModel;
            }
        }

        return $this->stores;
    }
}
