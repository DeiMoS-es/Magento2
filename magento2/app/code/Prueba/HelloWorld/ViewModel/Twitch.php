<?php
declare(strict_types=1);

namespace Prueba\HelloWorld\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Twitch implements ArgumentInterface
{
   public function getChat(): string
   {
       return 'Mensaje desde el ViewModel Twitch';
   }
}