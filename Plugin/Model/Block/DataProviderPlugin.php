<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroupStaging\Plugin\Model\Block;

use GhostUnicorns\CmsBlockCustomerGroup\Model\ResourceModel\GetCustomerGroupsByBlockId;
use Magento\Cms\Model\Block\DataProvider;

class DataProviderPlugin
{
    /**
     * @var GetCustomerGroupsByBlockId
     */
    private $getCustomerGroupsByBlockId;

    /**
     * @param GetCustomerGroupsByBlockId $getCustomerGroupsByBlockId
     */
    public function __construct(
        GetCustomerGroupsByBlockId $getCustomerGroupsByBlockId
    ) {
        $this->getCustomerGroupsByBlockId = $getCustomerGroupsByBlockId;
    }

    /**
     * @param DataProvider $subject
     * @param $result
     * @return array
     */
    public function afterGetData(DataProvider $subject, $result)
    {
        if ($result !== null) {
            foreach ($result as $blockId => $blockData) {
                if (!array_key_exists('identifier', $blockData)) {
                    return $result;
                }

                $rowId = array_key_exists('row_id', $blockData) ? (int)$blockData['row_id'] : (int)$blockId;

                $customerGroups = $this->getCustomerGroupsByBlockId->execute($rowId);

                $result[$blockId]['customer_group'] = $customerGroups;
            }
        }

        return $result;
    }
}
