<?php
declare(strict_types=1);

namespace Vendor\Hello\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    private $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        // Crea una página y dejar que el layout añada el bloque/template
        $page = $this->resultPageFactory->create();
        $page->getConfig()->getTitle()->set(__('Hola Magento — Demo'));
        return $page;
    }
}
