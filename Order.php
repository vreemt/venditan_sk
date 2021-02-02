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
     * @param int $id
     * @param int $courierId
     * @param int $customerId
     * @param string $description
     */
    function __construct(int $id, int $courierId, int $customerId, string $description)
    {
        $this->id = $id;
        $this->courierId = $courierId;
        $this->customerId = $customerId;
        $this->description = $description;
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