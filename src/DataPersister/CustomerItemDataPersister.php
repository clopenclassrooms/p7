<?php

namespace App\DataPersister;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Repository\CustomerRepository;
use App\Exception\CustomerBadRequest;

final class CustomerItemDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_security;
    private $_customerRepository;

    public function __construct(
        Security $security,
        EntityManagerInterface $entityManager,
        CustomerRepository $customerRepository
    ) {
        $this->_security = $security;
        $this->_entityManager = $entityManager;
        $this->_customerRepository = $customerRepository;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Customer;
    }

    public function persist($data, array $context = [])
    {
        //check data validity
        $pattern = "/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ[:blank:]-]{1,75})$/";
        if (
            !preg_match($pattern, $data->getFirstname()) or
            !preg_match($pattern, $data->getLastname())
        )
        {
            throw new CustomerBadRequest('Error in firstname or lastname value');
        }

        $userCompany = $this->_security->getUser()->getCompany();
        $data->setCompany($userCompany);
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
        $data->setCompany(null);
        return $data;
    }

    public function remove($data, array $context = [])
    {   
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
        return $data;
    }
}
