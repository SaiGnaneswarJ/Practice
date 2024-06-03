<?php
namespace Magento\Demo\Setup;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
class UpgradeData implements UpgradeDataInterface
{
    protected $_demoFactory;
    public function __construct(\Magento\Demo\Model\DemoFactory $demoFactory)
    {
        $this->_demoFactory = $demoFactory;
    }
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.1.1', '<'))
        {
            $data = ['name' => "Harish",'email' => "Harish@gmail.com",'mobile'=>"7895842154",'age'=>28];
            $example = $this->_demoFactory->create();
            $example->addData($data)->save();
        }
    }
}
