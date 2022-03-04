<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Customer;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Product;
use App\Repository\CompanyRepository;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $_faker;
    private $_companyRepository;
    private $_passwordHasher;
    private $_manager;
    private $_listOfCompany;

    public function __construct(
        CompanyRepository $companyRepository,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->_faker = Factory::create('fr_FR');
        $this->_companyRepository = $companyRepository;
        $this->_passwordHasher = $passwordHasher;
        $this->_listOfCompany = ["Bilemo", "free","SFR","Orange"];
    }

    public function load(ObjectManager $manager): void
    {
        $this->_manager = $manager;
        $this->createCompany();
        $this->createUser();
        $this->createCustomer(100);
        $this->createProduct(100);
    }

    public function createCompany()
    {
        foreach ($this->_listOfCompany as $companyName) {
            $company = new Company;
            $company->setName($companyName);
            $this->_manager->persist($company);
            $this->_manager->flush();
        }
    }

    public function createUser()
    {
        foreach ($this->_listOfCompany as $companyName) {
            $user = new User();
            $user->setUsername($companyName);
            $user->setPassword(
                $this->_passwordHasher->hashPassword(
                    $user,
                    $companyName
                )
            );
            $user->setCompany($this->_companyRepository->findOneByName($companyName));
            if ($companyName === "Bilemo") {
                $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
            } else {
                $user->setRoles(['ROLE_USER']);
            }
            $this->_manager->persist($user);
            $this->_manager->flush();
        }
    }

    public function createCustomer(int $nbCustomerByCompany)
    {
        foreach ($this->_listOfCompany as $companyName) {
            $companyName = $this->_companyRepository->findOneByName($companyName);
            if ($companyName != "Bilemo") {
                for ($i=0;$i < $nbCustomerByCompany;$i++) {
                    $customer = new Customer();
                    $customer->setFirstname($this->_faker->firstName());
                    $customer->setLastname($this->_faker->lastName());
                    $customer->setCompany($companyName);
                    $this->_manager->persist($customer);
                    $this->_manager->flush();
                }
            }
        }
    }

    public function createProduct(int $nbMobile)
    {
        $option = [
            "Apple"=>["iphone ", "iphone mini "],
            "Samsung"=>["Galaxy note ", "s "]
        ];
        for ($i=0;$i < $nbMobile;$i++) {
            $product = new Product();
            $brand = $this->_faker->randomElement(["Apple", "Samsung"]);
            $product->setBrand($brand);
            $product->setName($this->_faker->randomElement($option[$brand]) . $i);
            $product->setWeight($this->_faker->numberBetween(100, 400));
            $this->_manager->persist($product);
            $this->_manager->flush();
        }
    }
}
