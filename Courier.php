<?php

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
     * @param int $id
     * @param string $name
     * @param string $outputType
     * @param string $algorithm
     */
    function __construct(int $id, string $name, string $outputType = '', string $algorithm = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->outputType = $outputType;
        $this->consignmentCheck = $algorithm;

        // assign raw if no or empty output type specified
        if (!isset($outputType) || !in_array($outputType, $this->validOutputTypes)) {
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
            array('COURIER_', 'ORDER_', 'BATCH_'),
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
     * Get related consignments based on courier id
     * @return array
     */
    public function getConsignments(): array
    {
        $data = new HandleData('consignments');
        $list = $data->filter('courier', $this->id);
        return $data->getIds($list);
    }
}