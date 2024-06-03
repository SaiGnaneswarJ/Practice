<?php

namespace Magento\QuickOrder\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Checkout\Model\Cart;

/**
 * Class Addtocart
 * @package Magento\QuickOrder\Controller\Index
 */
class AddToCart extends Action
{
    protected $resultJsonFactory;


    protected $cart;

    /**
     * Addtocart constructor.
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param Cart $cart
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        Cart $cart
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->cart = $cart;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $productId = $this->getRequest()->getParam('entity_id');
        $qty = $this->getRequest()->getParam('qty');
        $selectedOption = $this->getRequest()->getParam('selected_option');

        print_r($selectedOption);

        $params = array(
            'product' => $productId,
            'qty' => $qty
        );

        $result = $this->cart->addProduct($productId, $params);
        $this->cart->save();

        $response = $this->resultJsonFactory->create();
        return $response->setData(['success' => true, 'message' => 'Product added to cart successfully']);
    }
}
