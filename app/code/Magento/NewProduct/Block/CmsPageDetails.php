<?php

namespace Magento\NewProduct\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory as PageCollectionFactory;

class CmsPageDetails extends Template
{
    protected $pageRepository;
    protected $pageId;
    protected $pageCollectionFactory;

    public function __construct(
        Context $context,
        PageRepositoryInterface $pageRepository,
        PageCollectionFactory $pageCollectionFactory,
        array $data = []
    ) {
        $this->pageRepository = $pageRepository;
        $this->pageCollectionFactory = $pageCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getPageIdFromCollection()
    {
        $pageCollection = $this->pageCollectionFactory->create();
        $pageCollection->addFieldToFilter('page_id', 9);
        $page = $pageCollection->getFirstItem();
        return $page->getId();
    }

    public function getCmsPageDetails()
    {
        $pageId = $this->getPageIdFromCollection();
        if ($pageId) {
            try {
                return $this->pageRepository->getById($pageId);
            } catch (\Exception $e) {
                return false;
            }
        }
        return false;
    }



    public function getCmsPageTitle()
    {
        $cmsPage = $this->getCmsPageDetails();
        return $cmsPage ? $cmsPage->getTitle() : null;
    }

    public function getCmsPageSubtitle()
    {
        $cmsPage = $this->getCmsPageDetails();
        return $cmsPage ? $cmsPage->getSubTitle() : null;
    }

    public function getCmsPageUrlKey()
    {
        $cmsPage = $this->getCmsPageDetails();
        return $cmsPage ? $cmsPage->getIdentifier() : null;
    }

    public function getCmsPageContentHeading()
    {
        $cmsPage = $this->getCmsPageDetails();
        return $cmsPage ? $cmsPage->getContentHeading() : null;
    }

    public function getCmsPageContent()
    {
        $cmsPage = $this->getCmsPageDetails();
        return $cmsPage ? $cmsPage->getContent() : null;
    }
}
