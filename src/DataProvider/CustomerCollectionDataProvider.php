<?php

namespace App\DataProvider;

use App\Entity\Customer;
use App\DataProvider\CustomerPaginator;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class CustomerCollectionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $_security;

    public function __construct(Security $security)
    {
        $this->_security = $security;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Customer::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $customers = $this->_security->getUser()->getCompany()->getCustomers();
        if (isset($context['filters']['page'])) {
            $page = $context['filters']['page'];
        } else {
            $page=1;
        }
        return new CustomerPaginator($customers, $page);
    }
}
