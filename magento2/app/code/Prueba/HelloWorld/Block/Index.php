<?php

declare(strict_types=1);

namespace Prueba\HelloWorld\Block;

use \Magento\Framework\View\Element\Template;

class Index extends Template{

    public function __construct( Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function getChat(): string
    {
        return 'Hello World from Prueba_HelloWorld!';
    }

}