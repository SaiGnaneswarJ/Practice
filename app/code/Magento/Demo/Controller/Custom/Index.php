<?php

namespace Magento\Demo\Controller\Custom;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use Magento\Cms\Model\PageFactory;
use Magento\Framework\Message\ManagerInterface;

class Index extends Action
{
    protected $urlRewriteFactory;
    protected $pageFactory;
    protected $messageManager;
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        UrlRewriteFactory $urlRewriteFactory,
        PageFactory $pageFactory,
        ManagerInterface $messageManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->urlRewriteFactory = $urlRewriteFactory;
        $this->pageFactory = $pageFactory;
        $this->messageManager = $messageManager;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $pageId = 8;
        $page = $this->pageFactory->create()->load($pageId);

        if (!$page->getId()) {
            $this->messageManager->addErrorMessage(__('CMS page not found.'));
            return;
        }

        $urlRewrite = $this->urlRewriteFactory->create();
        $urlRewrite->setStoreId(1);
        $urlRewrite->setEntityType('cms-page');
        $urlRewrite->setEntityId($pageId);
        $urlRewrite->setRequestPath('mypage');
        $urlRewrite->setTargetPath('cms/page/view/page_id/' . $pageId);
        $urlRewrite->setRedirectType(0);

        try {
            $urlRewrite->save();
            $this->messageManager->addSuccessMessage(__('URL Rewrite created successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error occurred while creating URL Rewrite: %1', $e->getMessage()));
        }

        // Load and render CMS page using block
        $resultPage = $this->resultPageFactory->create();
        $block = $resultPage->getLayout()->getBlock('custom.page');
        $block->setPage($page);
        return $resultPage;
    }
}
