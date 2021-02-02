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

    protected const DEFAULT_STATUS = 'open';

    /**
     * create from data
     * @param int $batchId
     * @param string $date
     * @param string $status
     * @throws Exception
     */
    function __construct(int $batchId, string $date = '', string $status = '')
    {
        $this->id = $batchId;
        $this->date = ($date ? new DateTime($date) : new DateTime());
        $this->status = ($status ?: self::DEFAULT_STATUS);
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