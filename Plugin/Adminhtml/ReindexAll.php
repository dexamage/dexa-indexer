<?php
/**
 * Copyright © 2015 Dexa. All rights reserved.
 * See Dexa.txt for license details.
 */
namespace Dexa\Indexer\Plugin\Adminhtml;

/**
 * ReindexAll
 */
class ReindexAll
{
    /**
     * @param \Magento\Indexer\Block\Backend\Container $subject
     * @return null
     */
    public function beforeGetCreateUrl(
        \Magento\Indexer\Block\Backend\Container $subject
    ){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $urlManager = $objectManager->get('Magento\Framework\UrlInterface');

        $url = $urlManager->getUrl('dexa_indexer/indexer/reindexAll', []);

        $subject->addButton(
            'reindex_all',
            [
                'label' => __('Reindex All'),
                'onclick' => "setLocation('{$url}')",
                'class' => 'add primary'
            ]
        );

        return null;
    }
}