<?php
namespace Magento\Demo\Setup;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
class InstallData implements InstallDataInterface
{
    protected $_demoFactory;
    public function __construct(\Magento\Demo\Model\DemoFactory $demoFactory)
    {
        $this->_demoFactory = $demoFactory;
    }
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $data = ['name' => "Gnaneswar",'email' => "Gnaneswar@gmail.com",'mobile'=>"8919110988",'age'=>25];
        $example = $this->_demoFactory->create();
        $example->addData($data)->save();
    }
}
