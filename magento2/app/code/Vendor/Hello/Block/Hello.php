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
     * Mensaje que devolvemos a la plantilla (puede venir de config en el futuro)
     */
    public function getGreeting(): string
    {
        return (string)__('¡Hola Magento! Esto es un módulo de demostración.');
    }

    /**
     * Ejemplo: devolver la url del frontend para esta ruta (útil para pruebas)
     */
    public function getHelloUrl(): string
    {
        return $this->getUrl('hello');
    }

    /**
     * Otro ejemplo: obtener la URL del skin / assets del módulo
     */
    public function getModuleAssetUrl(string $file): string
    {
        return $this->getViewFileUrl('Vendor_Hello::' . ltrim($file, '/'));
    }
}
