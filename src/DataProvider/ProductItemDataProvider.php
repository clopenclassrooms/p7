<?php

namespace App\DataProvider;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderTrait;
use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderInterface;
use App\Exception\DisplayCustomerWithoutAuthorizationException;
use App\Exception\ProductNotExistException;

final class ProductItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface, SerializerAwareDataProviderInterface
{
    use SerializerAwareDataProviderTrait;
    
    private $_security;
    private $_productRepository;
    private $_normalizerInterface;
    
    public function __construct(
        Security $security,
        ProductRepository $productRepository,
        NormalizerInterface $normalizerInterface
    ) {
        $this->_security = $security;
        $this->_productRepository = $productRepository;
        $this->_normalizerInterface = $normalizerInterface;
    }
    
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Product::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Product
    {
        
        $product = $this->_productRepository->find($id);
        if (!isset($product)) {
            
            throw new ProductNotExistException('Product not exist');
        }else{
            return $product;
        }
        
    }
}
