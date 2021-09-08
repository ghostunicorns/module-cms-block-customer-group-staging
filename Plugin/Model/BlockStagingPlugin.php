<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroupStaging\Plugin\Model;

use GhostUnicorns\CmsBlockCustomerGroup\Model\SaveCmsBlockCustomerGroup;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\CmsStaging\Model\BlockStaging;

class BlockStagingPlugin
{
    private SaveCmsBlockCustomerGroup $saveCmsBlockCustomerGroup;

    /**
     * @param SaveCmsBlockCustomerGroup $saveCmsBlockCustomerGroup
     */
    public function __construct(
        SaveCmsBlockCustomerGroup $saveCmsBlockCustomerGroup
    ) {
        $this->saveCmsBlockCustomerGroup = $saveCmsBlockCustomerGroup;
    }

    /**
     * @param BlockStaging $subject
     * @param callable $proceed
     * @param BlockInterface $block
     * @param $version
     * @param array $arguments
     * @return mixed
     */
    public function aroundSchedule(
        BlockStaging $subject,
        callable $proceed,
        BlockInterface $block,
        $version,
        array $arguments = []
    ) {
        $result = $proceed($block, $version, $arguments);

        $rowId = (int)$block->getData('row_id');
        $customerGroups = $block->getData('customer_group') ?: [];
        $this->saveCmsBlockCustomerGroup->execute($rowId, $customerGroups);

        return $result;
    }

    /**
     * @param BlockStaging $subject
     * @param callable $proceed
     * @param BlockInterface $block
     * @param $version
     * @return mixed
     */
    public function aroundUnschedule(
        BlockStaging $subject,
        callable $proceed,
        BlockInterface $block,
        $version
    ) {
        $result = $proceed($block, $version);

        $rowId = (int)$block->getData('row_id');
        $this->saveCmsBlockCustomerGroup->execute($rowId, []);

        return $result;
    }
}
