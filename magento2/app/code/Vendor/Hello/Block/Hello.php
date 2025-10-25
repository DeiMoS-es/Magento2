<?php
declare(strict_types=1);

namespace Vendor\Hello\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Hello extends Template
{
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * Mensaje que devolvemos a la plantilla
     */
    public function getGreeting(): string
    {
        return __('¡Hola Magento! Esto es un módulo de demostración.');
    }

    /**
     * Ejemplo: devolver la url del frontend para esta ruta (útil para pruebas)
     */
    public function getHelloUrl(): string
    {
        return $this->getUrl('hello');
    }
}
