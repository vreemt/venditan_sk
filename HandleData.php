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

    /**
     * save data
     * @param array $data - expects data without IDs
     * @param bool $ids_included - default false, set to modify data
     * @return bool returns true on success
     */
    public function save($data, $ids_included = false): bool
    {
        //logic to save array of data t
        if (!$ids_included) {
            //first, find the current data to create the csv from
            $path = $this->filePath . $this->dataType . ".csv";
            $previous_data = array_map('str_getcsv', file($path));

            // get the last element and calculate next id
            $last_element = array_pop($previous_data);
            $next_id = (int)$last_element[0] +1;

            foreach ($data as $i => $row) {
                $data[$i] = array_unshift($row, $next_id);
                $next_id++;
            }
        }
        //save data

        return false;
    }
}