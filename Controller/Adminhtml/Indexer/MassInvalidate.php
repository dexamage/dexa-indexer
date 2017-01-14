<?php
/**
 *
 * Copyright © 2016 Dexa. All rights reserved.
 * See LABELS.txt for license details.
 */
namespace Dexa\Indexer\Controller\Adminhtml\Indexer;

class MassInvalidate extends MassAbstract
{
    /**
     * Turn mview off for the given indexers
     *
     * @return void
     */
    public function execute()
    {
        $indexerIds = $this->getRequest()->getParam('indexer_ids');
        if (!is_array($indexerIds)) {
            $this->messageManager->addErrorMessage(__('Please select indexers.'));
        } else {
            try {
                $startTime = microtime(true);
                foreach ($indexerIds as $indexerId) {
                    /** @var \Magento\Framework\Indexer\IndexerInterface $model */
                    $indexer = $this->_objectManager->get('Magento\Framework\Indexer\IndexerRegistry')->get($indexerId);
                    $indexer->getState()
                        ->setStatus(\Magento\Framework\Indexer\StateInterface::STATUS_INVALID)
                        ->save();
                }
                $resultTime = microtime(true) - $startTime;

                $this->messageManager->addSuccessMessage(
                    __('%1 indexer(s) was invalidate in %2', count($indexerIds), gmdate('H:i:s', $resultTime))
                );
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __("We couldn't invalidate index(es)")
                );
            }
        }
        $this->_redirect('indexer/indexer/list');
    }
}
