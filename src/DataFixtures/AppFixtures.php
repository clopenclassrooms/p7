<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Company;
use App\Entity\Product;
use App\Repository\CompanyRepository;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private $_faker;
    private $_companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->_faker = Factory::create('fr_FR');
        $this->_companyRepository = $companyRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $this->createCompany(1,$manager);
        $this->createProduct(100,$manager);
        $this->createUser(10,$manager);
    }

    public function createCompany(int $nbCompany, ObjectManager $manager){
        for ($i=0;$i < $nbCompany;$i++)
        {
            $company = new Company();
            $company->setName($this->_faker->company());
            $manager->persist($company);
            $manager->flush();
        }
    }

    public function createProduct(int $nbMobile, ObjectManager $manager){
        $option = [
            "Apple"=>["iphone ", "iphone mini "],
            "Samsung"=>["Galaxy note ", "s "]
        ];
        for ($i=0;$i < $nbMobile;$i++)
        {
            $product = new Product();
            $brand = $this->_faker->randomElement(["Apple", "Samsung"]);
            $product->setBrand($brand);
            $product->setName($this->_faker->randomElement($option[$brand]) . $i);
            $product->setWeight($this->_faker->numberBetween(100,400));
            $manager->persist($product);
            $manager->flush();
        }
    }

    public function createUser(int $nbUser, ObjectManager $manager){
        $allCompany = $this->_companyRepository->findAll();
        for ($i=0;$i < $nbUser;$i++)
        {
            $user = new User();
            $user->setFirstname($this->_faker->firstName());
            $user->setLastname($this->_faker->lastname());
            $user->setCompany($this->_faker->randomElement($allCompany));
            $manager->persist($user);
            $manager->flush();
        } 
    }
}
