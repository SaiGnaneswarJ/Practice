<?php

namespace Kensium\File\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Filesystem;

/**
 * Class Gallery
 * @package Kensium\File\Block
 */
class Gallery extends Template
{
    protected $filesystem;

    /**
     * Gallery constructor.
     * @param Template\Context $context
     * @param Filesystem $filesystem
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Filesystem $filesystem,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->filesystem = $filesystem;
    }

    /**
     * @return array
     */
    public function getUploadedImages()
    {
        $images = [];
        $directory = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath('kensium/files/default');
        $fileList = scandir($directory);
        foreach ($fileList as $file) {
            if ($file !== '.' && $file !== '..') {
                $images[] = $file;
            }
        }
        return $images;
    }

    /**
     * @param $fileName
     * @return string
     */
    public function getImageUrl($fileName)
    {
        return $this->_urlBuilder->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]) . 'kensium/files/default/' . $fileName;
    }
}
