<?php

include('HandleData.php');
include('Courier.php');
include('Order.php');
include('Batch.php');
include('Consignment.php');

echo "<pre>" . PHP_EOL;
echo "This handles the data used in the system " . PHP_EOL;

$getCouriers = new HandleData('couriers');
$courierData = $getCouriers->get();

print_r($courierData);

$fetch = new HandleData('orders');
$orderData = $fetch->get();

print_r($orderData);

$fetch = new HandleData('batches');
$batchData = $fetch->get();

print_r($batchData);

echo "Creating new batch... " . PHP_EOL;

$lastElement = array_pop($batchData);
$batchId = (int)$lastElement[0] + 1;

$batch = new Batch($batchId);
$date = $batch->getDate();
$dateAsId = $date->format('Ymd');

$orderCollection = [];
$consignmentCollection = [];

foreach ($orderData as $row) {
    // create order based on data
    $order = new Order((int)$row[0], (int)$row[1], (int)$row[2], $row[3]);
    $orderId = $order->id;
    $courierId = $order->getCourier();

    // populate Courier based on data
    $courierRow = $getCouriers->getById($courierId);
    $courierRow[0] = (int) $courierRow[0];
    $courier = new Courier(...$courierRow);

    // generate consignment number
    $consignmentNumber = $courier->getConsignmentNumber($batch, $order);

    // create consignment with data
    $consignmentId = $dateAsId.$orderId; //concatenated so we end up with a 9 digit number
    $consignment = new Consignment($consignmentId, $batchId, $orderId, $courierId, $consignmentNumber);

    $orderCollection[] = $order;
    $consignmentCollection[] = $consignment;
}

var_dump($orderCollection);

var_dump($consignmentCollection);


