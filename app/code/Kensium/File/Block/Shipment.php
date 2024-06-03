<?php

namespace Kensium\File\Block;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Convert\Order as ConvertOrder;
use Magento\Shipping\Model\ShipmentNotifier;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\DB\Transaction;

/**
 * Class Shipment
 * @package Kensium\File\Block
 */
class Shipment extends Template
{
    protected $orderRepository;
    protected $convertOrder;
    protected $shipmentNotifier;
    protected $transaction;
    protected $productRepository;

    /**
     * Shipment constructor.
     * @param Template\Context $context
     * @param OrderRepositoryInterface $orderRepository
     * @param ConvertOrder $convertOrder
     * @param ShipmentNotifier $shipmentNotifier
     * @param Transaction $transaction
     * @param ProductRepositoryInterface $productRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        OrderRepositoryInterface $orderRepository,
        ConvertOrder $convertOrder,
        ShipmentNotifier $shipmentNotifier,
        Transaction $transaction,
        ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->orderRepository = $orderRepository;
        $this->convertOrder = $convertOrder;
        $this->shipmentNotifier = $shipmentNotifier;
        $this->transaction = $transaction;
        $this->productRepository = $productRepository;
    }

    /**
     * @param $orderId
     * @return mixed
     * @throws LocalizedException
     */
    public function createShipmentForOrder($orderId)
    {
        $order = $this->orderRepository->get($orderId);

        // Debugging output
        echo "Order ID: " . $orderId . PHP_EOL;
//        var_dump($order->getData());
        echo "Order Status: " . $order->getStatus() . PHP_EOL;
        echo "Order State: " . $order->getState() . PHP_EOL;

        if (!$order->canShip()) {
            throw new LocalizedException(__("You can't create the Shipment of this order."));
        }

        $orderShipment = $this->convertOrder->toShipment($order);

//        var_dump($orderShipment);

        foreach ($order->getAllItems() as $orderItem) {
            // Check virtual item and item Quantity
            if (!$orderItem->getQtyToShip() || $orderItem->getIsVirtual()) {
                continue;
            }

            $qty = $orderItem->getQtyToShip();
            $shipmentItem = $this->convertOrder->itemToShipmentItem($orderItem)->setQty($qty);
            $orderShipment->addItem($shipmentItem);
        }

        $orderShipment->register();
        $orderShipment->getOrder()->setIsInProcess(true);


        $shipmentExtension = $orderShipment->getExtensionAttributes();
        if ($shipmentExtension === null) {
            $shipmentExtension = $this->convertOrder->create()->getExtensionAttributes();
        }
        if ($shipmentExtension) {
            $shipmentExtension->setSourceCode('default');
            $orderShipment->setExtensionAttributes($shipmentExtension);
        }

        try {
            $this->transaction->addObject($orderShipment)
                ->addObject($orderShipment->getOrder())
                ->save();
            $this->shipmentNotifier->notify($orderShipment);
        } catch (\Exception $e) {
            throw new LocalizedException(__("An error occurred while creating the shipment: " . $e->getMessage()));
        }

        return $orderShipment->getId();
    }
}
