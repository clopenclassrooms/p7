<?php

namespace App\DataPersister;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

final class CustomerItemDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_security;

    public function __construct(
        Security $security,
        EntityManagerInterface $entityManager
    ) {
        $this->_security = $security;
        $this->_entityManager = $entityManager;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Customer;
    }

    public function persist($data, array $context = [])
    {
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
