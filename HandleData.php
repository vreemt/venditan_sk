<?php

/**
 * Class HandleData
 * @author Sandra Koning
 *
 * handle data - abstract from db/other source
 */
class HandleData
{
    protected $filePath = 'data/';
    protected $dataType;
    protected $dataTypes = [ 'orders', 'couriers', 'batches', 'consignments' ];

    /**
     * HandleData constructor.
     * @param string $dataType
     * @throws Exception
     */
    function __construct(string $dataType) {
        if (!in_array($dataType, $this->dataTypes)) {
            throw new Exception("invalid data type");
        }

        $this->dataType = $dataType;
    }

    public function get(): array
    {
        $path = $this->filePath . $this->dataType . ".csv";

        return array_map('str_getcsv', file($path));
    }
}