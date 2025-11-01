<?php
declare(strict_types=1);

namespace Deimos\Checkout\Plugin;

use Psr\Log\LoggerInterface;
use Magento\Checkout\Model\ShippingInformationManagement;
use Magento\Checkout\Api\Data\ShippingInformationInterface;

class ShippingInformationLogger
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * After plugin for saveAddressInformation.
     *
     * @param ShippingInformationManagement $subject
     * @param mixed $result
     * @param int $cartId
     * @param ShippingInformationInterface $addressInformation
     * @return mixed
     */
    public function afterSaveAddressInformation(
        ShippingInformationManagement $subject,
        $result,
        int $cartId,
        ShippingInformationInterface $addressInformation
    ) {
        $address = $addressInformation->getShippingAddress();
        if ($address && (string)$address->getCountryId() === 'US') {
            $this->logger->info(sprintf(
                'Deimos_Checkout: cartId=%d shipping country=US postcode=%s',
                $cartId,
                (string)$address->getPostcode()
            ));
        }

        return $result;
    }
}
