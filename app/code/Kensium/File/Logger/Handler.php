<?php
namespace Kensium\File\Logger;

use Monolog\Logger;

class Handler extends \Magento\Framework\Logger\Handler\Base
{
    protected $loggerType = Logger::NOTICE;
    protected $fileName = '/var/log/kensium.log';
}
