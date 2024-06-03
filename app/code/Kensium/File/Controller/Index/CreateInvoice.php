<?php

namespace Kensium\File\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Service\InvoiceService;
use Magento\Framework\DB\Transaction;
use Magento\Sales\Model\Order\Email\Sender\InvoiceSender;
use Magento\Framework\Exception\LocalizedException;
use Kensium\File\Logger\Logger;

class CreateInvoice extends Action
{
    protected $orderRepository;
    protected $invoiceService;
    protected $transaction;
    protected $invoiceSender;
    protected $logger;

    public function __construct(
        Context $context,
        OrderRepositoryInterface $orderRepository,
        InvoiceService $invoiceService,
        InvoiceSender $invoiceSender,
        Transaction $transaction,
        Logger $logger
    ) {
        $this->orderRepository = $orderRepository;
        $this->invoiceService = $invoiceService;
        $this->transaction = $transaction;
        $this->invoiceSender = $invoiceSender;
        $this->logger = $logger;
        parent::__construct($context);
    }

    public function execute()
    {
        $orderId = 29;

        try {
            if (!$orderId) {
                throw new LocalizedException(__('Order ID is required.'));
            }

            $order = $this->orderRepository->get($orderId);

            if ($order->canInvoice()) {
                $invoice = $this->invoiceService->prepareInvoice($order);
                if (!$invoice) {
                    throw new LocalizedException(__('We can\'t create an invoice.'));
                }

                $invoice->register();
                $invoice->getOrder()->setIsInProcess(true);

                $transactionSave = $this->transaction
                    ->addObject($invoice)
                    ->addObject($invoice->getOrder());

                $transactionSave->save();

                $this->invoiceSender->send($invoice);

                $order->addStatusHistoryComment(
                    __('Notified customer about invoice creation #%1.', $invoice->getId())
                )->setIsCustomerNotified(true)
                    ->save();

                $this->logger->notice(__('Successfully created invoice #%1 for order #%2.', $invoice->getId(), $orderId));
                echo "Invoice is created for order id :"   .$orderId;
            } else {
                throw new LocalizedException(__('The order does not allow an invoice to be created.'));
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->logger->notice($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('An error occurred while creating the invoice.'));
            $this->logger->critical($e->getMessage());
        }
    }
}

