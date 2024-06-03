<?php

namespace Magento\Demo\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Demo\Model\DemoFactory;
use Magento\Framework\Console\Cli;

class AddData extends Command
{
    const INPUT_KEY_NAME = 'name';
    const INPUT_KEY_EMAIL = 'email';
    const INPUT_KEY_MOBILE = 'mobile';
    const INPUT_KEY_AGE = 'age';



    private $DemoFactory;

    public function __construct(DemoFactory $DemoFactory)
    {
        $this->DemoFactory = $DemoFactory;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('demo:data:add')
            ->addArgument(
                self::INPUT_KEY_NAME,
                InputArgument::REQUIRED,
                'Data Name'
            )->addArgument(
                self::INPUT_KEY_EMAIL,
                InputArgument::REQUIRED,
                'Data Email'
            )->addArgument(
                self::INPUT_KEY_MOBILE,
                InputArgument::REQUIRED,
                'Data Mobile'
            )->addArgument(
                self::INPUT_KEY_AGE,
                InputArgument::REQUIRED,
                'Data Age'
            );

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = $this->DemoFactory->create();
        $data->setName($input->getArgument(self::INPUT_KEY_NAME));
        $data->setEmail($input->getArgument(self::INPUT_KEY_EMAIL));
        $data->setMobile($input->getArgument(self::INPUT_KEY_MOBILE));
        $data->setAge($input->getArgument(self::INPUT_KEY_AGE));
        $data->setIsObjectNew(true);
        $data->save();
        return Cli::RETURN_SUCCESS;
    }
}
