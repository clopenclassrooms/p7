<?php

namespace App\DataProvider;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderTrait;
use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderInterface;
use App\Exception\DisplayCustomerWithoutAuthorizationException;
use App\Exception\CustomerNotExistException;

final class CustomerItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface, SerializerAwareDataProviderInterface
{
    use SerializerAwareDataProviderTrait;
    
    private $_security;
    private $_customerRepository;
    private $_normalizerInterface;
    
    public function __construct(
        Security $security,
        CustomerRepository $customerRepository,
        NormalizerInterface $normalizerInterface
    ) {
        $this->_security = $security;
        $this->_customerRepository = $customerRepository;
        $this->_normalizerInterface = $normalizerInterface;
    }
    
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Customer::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Customer
    {
        $customer = $this->_customerRepository->find($id);
        if (!isset($customer)) {
            throw new CustomerNotExistException('Customer not found');
        }
        $customersCompany = $customer->getCompany();
        $userCompany = $this->_security->getUser()->getCompany();
        if ($userCompany === $customersCompany) {
            return $customer;
        } else {
            throw new DisplayCustomerWithoutAuthorizationException('You have not Authorization for display this customer');
        }
    }
}
