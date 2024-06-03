<?php

namespace Kensium\File\Model\Total\Quote;

/**
 * Class CustomDiscount
 * @package Kensium\File\Model\Total\Quote
 */
class CustomDiscount extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this|\Magento\Quote\Model\Quote\Address\Total\AbstractTotal
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);

        $TotalAmount = $total->getSubtotal();
        $discountAmount = -$TotalAmount / 20; // set 15% discount  -originalprice/20

        $total->setDiscountDescription('');
        $total->setDiscountAmount($discountAmount);
        $total->setBaseDiscountAmount($discountAmount);
        $total->setSubtotalWithDiscount($total->getSubtotal() + $discountAmount);
        $total->setBaseSubtotalWithDiscount($total->getBaseSubtotal() + $discountAmount);

        $total->addTotalAmount($this->getCode(), $discountAmount);
        $total->addBaseTotalAmount($this->getCode(), $discountAmount);

        return $this;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return array|null
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $amount = $total->getDiscountAmount();
        $description = $total->getDiscountDescription() ?: '';

        if ($amount != 0) {
            return [
                'code' => $this->getCode(),
                'title' => strlen($description) ? __('Discount (%1)', $description) : __('Discount'),
                'value' => $amount
            ];
        }
        return null;
    }
}
