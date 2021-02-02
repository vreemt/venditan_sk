<?php

/**
 * Class HandleData
 * @author Sandra Koning
 *
 * handle data - abstract from db/other source
 */
class HandleData
{
    public $raw = [];
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

    /**
     * get data from eg csv
     * @return array
     */
    public function get(): array
    {
        $path = $this->filePath . $this->dataType . ".csv";

        $this->raw = array_map('str_getcsv', file($path));
        return $this->raw;
    }

    /**
     * get single item based on id
     * @param $id
     * @return array
     */
    public function getById($id): array
    {
        if (empty($this->raw)) {
            $this->get();
        }
        $getMatch = $this->filter('id', $id);
        return array_shift($getMatch);
    }

    /**
     * only return IDs for the data found
     * @param array $data - uses raw if empty
     * @return array
     */
    public function getIds(array $data): array
    {
        if (empty($data)) {
            $data = $this->raw;
        }
        return array_column($data, 0);
    }

    /**
     * filtering of data based on type and field
     * @param string $field which field to filter
     * @param string $value what to filter on
     * @return array
     */
    public function filter(string $field, string $value): array
    {
        if (!$this->raw) {
            $this->raw = $this->get();
        }

        // check which field is where for which data type
        switch ($this->dataType) {
            case 'consignments':
                if ($field == 'courier') {
                    //courier is the fourth field (index 3) in consignment data
                    return array_filter($this->raw, function($row) use ($value) {
                        return $row[3] == $value;
                    });
                }
                break;
            default:
                    return array_filter($this->raw, function($row) use ($value) {
                        return $row[0] == $value;
                    });
        }
        return $this->raw;
    }

    /**
     * save data
     * @param array $data - expects data without IDs
     * @param bool $ids_included - default false, set to modify data
     * @return bool returns true on success
     */
    public function save($data, $ids_included = false): bool
    {
        //logic to save array of data
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
        // save data

        return false;
    }
}