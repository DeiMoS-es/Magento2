<?php

declare(strict_types=1);

namespace Prueba\HelloWorld\Controller\Index;

use Laminas\Feed\Reader\Http\ResponseInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;


class ApiJson implements HttpGetActionInterface{

    public function __construct(private readonly JsonFactory $jsonFactory) { }

    public function execute(): ResultInterface|ResponseInterface
    {
        $result = $this->jsonFactory->create();
        $data = ['message' => 'Hello, World!'];
        $result->setData($data);
        return $result;
    }
}