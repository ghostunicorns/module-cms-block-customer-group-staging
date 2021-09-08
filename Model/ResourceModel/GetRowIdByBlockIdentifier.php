<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroupStaging\Model\ResourceModel;

use GhostUnicorns\CmsBlockCustomerGroup\Model\ResourceModel\GetBlockIdByBlockIdentifierInterface;
use Magento\Cms\Model\GetBlockByIdentifier;
use Magento\Framework\Exception\NoSuchEntityException;

class GetRowIdByBlockIdentifier implements GetBlockIdByBlockIdentifierInterface
{
    /**
     * @var GetBlockByIdentifier
     */
    private $getBlockByIdentifier;

    /**
     * @param GetBlockByIdentifier $getBlockByIdentifier
     */
    public function __construct(
        GetBlockByIdentifier $getBlockByIdentifier
    ) {
        $this->getBlockByIdentifier = $getBlockByIdentifier;
    }

    /**
     * @param string $blockIdentifier
     * @param int|null $storeId
     * @return int
     * @throws NoSuchEntityException
     */
    public function execute(string $blockIdentifier, int $storeId = null): int
    {
        $block = $this->getBlockByIdentifier->execute($blockIdentifier, $storeId);
        return (int)$block->getRowId();
    }
}
