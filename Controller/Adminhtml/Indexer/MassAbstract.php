<?php
/**
 *
 * Copyright © 2016 Dexa. All rights reserved.
 * See LABELS.txt for license details.
 */
namespace Dexa\Indexer\Controller\Adminhtml\Indexer;

abstract class MassAbstract extends \Magento\Indexer\Controller\Adminhtml\Indexer
{
    /**
     * Check ACL permissions
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        switch ($this->_request->getActionName()) {
            case 'massReindex':
            case 'massInvalidate':
            case 'massValidate':
                return $this->_authorization->isAllowed('Magento_Indexer::changeMode');
        }

        return parent::_isAllowed();
    }
}
