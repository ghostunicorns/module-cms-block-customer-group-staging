<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroupStaging\Plugin\Model;

use GhostUnicorns\CmsBlockCustomerGroup\Model\IsBlockAllowed;
use Magento\Cms\Model\BlockRepository;
use Magento\Framework\Exception\NoSuchEntityException;

class IsBlockAllowedPlugin
{
    /**
     * @var BlockRepository
     */
    private $blockRepository;

    /**
     * @param BlockRepository $blockRepository
     */
    public function __construct(
        BlockRepository $blockRepository
    ) {
        $this->blockRepository = $blockRepository;
    }

    /**
     * @param IsBlockAllowed $subject
     * @param callable $proceed
     * @param int $blockId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function aroundExecute(
        IsBlockAllowed $subject,
        callable $proceed,
        int $blockId
    ) {
        $block = $this->blockRepository->getById($blockId);
        $rowId = (int)$block->getRowId();
        return $proceed($rowId);
    }
}
