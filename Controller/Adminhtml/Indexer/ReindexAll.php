<?php
/**
 *
 * Copyright © 2016 Dexa. All rights reserved.
 * See LABELS.txt for license details.
 */
namespace Dexa\Indexer\Controller\Adminhtml\Indexer;

class ReindexAll extends \Magento\Indexer\Controller\Adminhtml\Indexer
{
    /**
     * Check ACL permissions
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Turn mview off for the given indexers
     *
     * @return void
     */
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $collectionFactory = $objectManager->create('Magento\Indexer\Model\Indexer\CollectionFactory');
        $indexers = $collectionFactory->create()->getItems();

        try {
            $startTime = microtime(true);
            foreach ($indexers as $indexer) {
                $indexer->reindexAll();
                $indexer->getState()
                    ->setStatus(\Magento\Framework\Indexer\StateInterface::STATUS_VALID)
                    ->save();

            }
            $resultTime = microtime(true) - $startTime;

            $this->messageManager->addSuccessMessage(
                __('aLL indexes has been rebuilt successfully in ' . gmdate('H:i:s', $resultTime))
            );
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __("We couldn't reindex")
            );
        }

        $this->_redirect('indexer/indexer/list');
    }
}
