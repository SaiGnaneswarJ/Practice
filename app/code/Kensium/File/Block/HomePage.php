<?php

namespace Kensium\File\Block;

/**
 * Class HomePage
 * @package Kensium\File\Block
 */
class HomePage extends \Magento\Framework\View\Element\Template
{
    protected $logo;

    /**
     * HomePage constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Theme\Block\Html\Header\Logo $logo
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Theme\Block\Html\Header\Logo $logo,
        array $data = []
    )
    {
        $this->logo = $logo;
        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    // Check if current url is home page or not
    public function isHomePage()
    {
        return $this->logo->isHomePage();
    }
}

?>