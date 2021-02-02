<?php

/**
 * Class Order
 * @author Sandra Koning
 *
 * create order object from data
 */
class Order
{
    public $id;
    protected $courierId;
    protected $customerId;
    protected $description;

    /**
     * create order from data
     * @param array $data
     */
    function __construct(array $data)
    {
        $this->id = $data[0];
        $this->courierId = $data[1];
        $this->customerId = $data[2];
        $this->description = $data[3];
    }

    /**
     * get courier id
     * @return int
     */
    public function getCourier(): int
    {
        return (int)$this->courierId;
    }

    /**
     * determine if courier for this order is valid
     * allow for more logic to be assigned to this check
     * @param array $validCouriers
     * @return bool
     */
    public function checkValidCourier(array $validCouriers): bool
    {
        if (!empty($validCouriers) && in_array($this->courierId, $validCouriers)) {
            return true;
        }
        return false;
    }
}