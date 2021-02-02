<?php

/**
 * Class Batch
 * @author Sandra Koning
 *
 * a batch has limited properties - id, date, status
 */
class Batch
{
    public $id;
    protected $date;
    protected $status;

    const DEFAULT_BATCH_STATUS = 'open';

    /**
     * create from data
     * @param array $data
     * @throws Exception
     */
    function __construct(array $data)
    {
        $this->id = (int)$data[0];
        $this->date = ($data[1] ? new DateTime($data[1]) : new DateTime());
        $this->status = ($data[2] ?: DEFAULT_BATCH_STATUS);
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
        return $this->date;
    }

}