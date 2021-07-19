<?php

namespace Vgroup\SafetyHubApp\Model;

use Magento\Framework\App\ResourceConnection;

class Storage {

    /**
     * DB Storage table name
     */
    const TABLE_NAME = 'safetyhubapp_items_products';

    /**
     * Code of "Integrity constraint violation: 1062 Duplicate entry" error
     */
    const ERROR_CODE_DUPLICATE_ENTRY = 23000;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;

    /**
     * @var Resource
     */
    protected $resource;

    /**
     * @param \Magento\Framework\App\ResourceConnection $resource
     */
    public function __construct(
    ResourceConnection $resource
    ) {
        $this->connection = $resource->getConnection();
        $this->resource = $resource;
    }

    /**
     * Insert multiple
     *
     * @param array $data
     * @return void
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Exception
     */
    public function insertMultiple($tableName = self::TABLE_NAME, $data) {
        try {
            $tableName = $this->resource->getTableName($tableName);
            return $this->connection->insertMultiple($tableName, $data);
        } catch (\Exception $e) {
            if ($e->getCode() === self::ERROR_CODE_DUPLICATE_ENTRY && preg_match('#SQLSTATE\[23000\]: [^:]+: 1062[^\d]#', $e->getMessage())
            ) {
                throw new \Magento\Framework\Exception\AlreadyExistsException(
                __('URL key for specified store already exists.')
                );
            }
            throw $e;
        }
    }

    public function deleteMultiple($tableName = self::TABLE_NAME, $row_id, $serial_numbers) {
        try {
            $tableName = $this->resource->getTableName($tableName);
            $sql = "DELETE  FROM $tableName WHERE row_id = $row_id and serial_number in($serial_numbers)";
            $this->connection->query($sql);
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
