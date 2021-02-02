<?php

/**
 * Class Order
 * @author Sandra Koning
 *
 * a batch has limited properties - id, date, status
 */
class Batch
{
    public $id;
    protected $date;
    protected $status;

    /**
     * create from data
     * @param array $data
     */
    function __construct(array $data)
    {
        $this->id = (int)$data[0];
        $this->date = $data[1];
        $this->status = $data[2];
    }

    /**
     * get consignments
     * @return array
     */
    public function getConsignments(): array
    {
        // logic to list all consignments in this batch
        return [];
    }

    /**
     * get couriers
     * @return array
     */
    public function getCouriers(): array
    {
        // logic to list all couriers in this batch
        return [];
    }

    /**
     * return status
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * return date
     * @return DateTime
     * @throws Exception
     */
    public function getDate(): DateTime
    {
        return new DateTime($this->date);
    }
}