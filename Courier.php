<?php

use Exception;

/**
 * Class Courier
 * @author Sandra Koning
 *
 * return courier information
 */
class Courier
{
    public $id;
    public $name;
    public $outputType;
    private $consignmentCheck;

    protected $validOutputTypes = [ 'raw', 'json', 'csv' ];

    /**
     * create courier from id, name, output type and consignment algorithm
     * @param array $data
     */
    function __construct(array $data)
    {
        $this->id = $data[0];
        $this->name = $data[1];
        $this->outputType = $data[2];
        $this->consignmentCheck = $data[3];

        // assign raw if no or empty output type specified
        if (!isset($data[2]) || !in_array($data[2], $this->validOutputTypes)) {
            $this->outputType = $this->validOutputTypes[0];
        }
    }

    /**
     * Get consignment number
     *
     * @param Batch $batch
     * @param Order $order
     * @throws Exception
     * @return string
     */
    public function getConsignmentNumber(Batch $batch, Order $order): string
    {
        if (!$batch || !$order || !$this->consignmentCheck) {
            throw new Exception('not found details to create consignment number with');
        }
        // use algorithm to create consignment number
        return str_replace(
            array('COURIER', 'ORDER_NO', 'BATCH_NO'),
            array($this->name, $order->id, $batch->id),
            $this->consignmentCheck
        );

    }

    /**
     * Get related orders based on courier id
     * there are better ways to do this with db data or eg Laravel collections
     * @return array
     */
    public function getOrders(): array
    {
        $courierOrders = [];

        $objects = new HandleData('orders');
        $data = $objects->get();
        foreach ($data as $details) {
            $order = new Order($details);

            if ($order->getCourier() == $this->id) {
                $courierOrders[] = $order;
            }
        }
        return $courierOrders;
    }

    /**
     * Get related orders based on courier id
     * there are better ways to do this with db data or eg Laravel collections
     * @return array
     */
    public function getConsignments(): array
    {
        $batches = new HandleData('batches');
        $list = $batches->filter('courier', $this->id);
        return $list->getConsignments();
    }
}