<?php
namespace Wigzo\Service\Controller;

abstract class Module extends \Magento\Framework\App\Action\Action {

    protected $pageSize = null;
    protected $pageNum = 0;
    protected $startDate = null;
    protected $endDate = null;
    protected $sortDir = 'asc';
    protected $filterField = 'created_at';
    protected $id = null;
    protected $ignoreCost = null;
    protected $customAttr = null;
    protected $helper;

    protected function initParams() {
        if ((bool) $pageSize = $this->getRequest()->getParam('page_size')) {
            $this->pageSize = $pageSize;
        }
        if ((bool) $pageNum = $this->getRequest()->getParam('page_num')) {
            $this->pageNum = $pageNum;
        }
        if ((bool) $startDate = $this->getRequest()->getParam('start_date')) {
            $this->startDate = $startDate;
            if ((bool) $endDate = $this->getRequest()->getParam('end_date')) {
                $this->endDate = $endDate;
            } else {
                $this->endDate = date('Y-m-d');
            }
        } elseif ((bool) $updatedStartDate = $this->getRequest()->getParam('updated_start_date')) {
            $this->filterField = 'updated_at';
            $this->startDate = $updatedStartDate;
            if ((bool) $updatedEndDate = $this->getRequest()->getParam('updated_end_date')) {
                $this->endDate = $updatedEndDate;
            } else {
                $this->endDate = date('Y-m-d');
            }
        }
        if ((bool) $sortDir = $this->getRequest()->getParam('sort_dir')) {
            $this->sortDir = $sortDir;
        }
        if ((bool) $id = $this->getRequest()->getParam('id')) {
            $this->id = $id;
        }
        if ((bool) $customAttr = $this->getRequest()->getParam('customAttr')) {
            $this->customAttr = $customAttr;
        }
        if ((bool) $ignoreCost = $this->getRequest()->getParam('ignore_cost')) {
            $this->ignoreCost = $ignoreCost;
        }
    }

    protected function isEnabled() {
        return $this->helper->getConfig()['enabled'];
    }

    protected function isAuthorized() {

        $token = $this->helper->getConfig()['security_token'];
	


//        $authToken = (isset($_SERVER['HTTP_X_WIGZO_TOKEN']) ? $_SERVER['HTTP_X_WIGZO_TOKEN'] : $_SERVER['X_WIGZO_TOKEN']);
//	    $authToken = (isset($_SERVER['HTTP_X_WIGZO_TOKEN']) ? $_SERVER['HTTP_X_WIGZO_TOKEN'] : '07d68efdc87dfe3a2364014ef6fc364a77c8c510');
//
//        if (empty($authToken)) {
//            return false;
//        }
//
//        if (trim($token) != trim($authToken)) {
//            $this->helper->log('Wigzo feed request with invalid security token: '.$authToken.' compared to stored token: '.$token);
//            return false;
//        }

        return true;
    }
}
