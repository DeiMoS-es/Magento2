<?php

declare(strict_types=1);

namespace Prueba\HelloWorld\Block;

use \Magento\Framework\View\Element\Template;

class Index extends Template{

    public function getChat(): string
    {
        return 'Hello World from Prueba_HelloWorld!';
    }

}