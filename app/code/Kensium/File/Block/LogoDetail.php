<?php

namespace Kensium\File\Block;
use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Theme\Block\Html\Header\Logo;

/**
 * Class LogoDetail
 * @package Kensium\File\Block
 */
class LogoDetail extends Template
{
    protected $_logo;

    /**
     * LogoDetail constructor.
     * @param Context $context
     * @param Logo $logo
     * @param array $data
     */
    public function __construct(
        Context $context,
        Logo $logo,
        array $data = []
    )
    {
        $this->_logo = $logo;
        parent::__construct($context, $data);
    }

    /**
     * Get logo image URL
     *
     * @return string
     */
    public function getLogoSrc()
    {
        return $this->_logo->getLogoSrc();
    }

    /**
     * Get logo text
     *
     * @return string
     */
    public function getLogoAlt()
    {
        return $this->_logo->getLogoAlt();
    }

    /**
     * Get logo width
     *
     * @return int
     */
    public function getLogoWidth()
    {
        return $this->_logo->getLogoWidth();
    }

    /**
     * Get logo height
     *
     * @return int
     */
    public function getLogoHeight()
    {
        return $this->_logo->getLogoHeight();
    }
}

?>