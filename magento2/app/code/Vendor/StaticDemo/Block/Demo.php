<?php
declare(strict_types=1);

namespace Vendor\StaticDemo\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Demo extends Template
{
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function getStaticText(): string
    {
        return 'Este es un bloque estático — todo el HTML siguiente debe mostrarse tal cual.';
    }
}