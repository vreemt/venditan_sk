<?php

/**
 * Parcel/consignment for each order
 *
 * Author: Sandra Koning
 */

class Consignment {

    //properties
    protected $id;
    protected $batchId;
    protected $orderId;
    protected $courierId;
    protected $consignmentNumber; //calculated based on courier's algorithm

    private $order, $batch, $courier;

    /**
     * Use array/object of data matching properties
     *
     * @param $id
     * @param $batchId
     * @param $orderId
     * @param $courierId
     * @param $consignmentNumber
     */
    public function __construct($id, $batchId, $orderId, $courierId, $consignmentNumber)
    {
        $this->id = (int)$id;
        $this->batchId = (int)$batchId;
        $this->orderId = (int)$orderId;
        $this->courierId = (int)$courierId;
        $this->consignmentNumber = $consignmentNumber;
    }


    /**
     * Each fields gets its own funcs
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getCourierId(): int
    {
        return $this->courierId;
    }

    //string calculated with courier algorithm
    public function getConsignmentNumber(): string
    {
        return $this->consignmentNumber;
    }

    public function getBatchId(): int
    {
        return $this->batchId;
    }



}
