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

    protected $validOutputTypes = [ 'raw', 'json', 'csv' ];

    /**
     * create courier from id, name, output type
     * @param array $data
     */
    function __construct(array $data)
    {
        $this->id = $data[0];
        $this->name = $data[1];
        $this->outputType = $data[2];

        // assign raw if no or empty output type specified
        if (!isset($data[2]) || !in_array($data[2], $this->validOutputTypes)) {
            $this->outputType = $this->validOutputTypes[0];
        }
    }

    /**
     * Get consignment number
     *
     * @param Order $order
     * @throws Exception
     * @return string
     */
    public function getConsignmentNumber(Order $order): string
    {
        if (!$order) {
            throw new Exception('not found order to create consignment number from');
        }
        switch ($this->id) {
            case 1:
                return "RM" . $order->id;
            case 2:
                return "anc" . $order->id;
            case 3:
                return "test" .rand(5);
            default:
                return 'invalid courier';
        }
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