<?php
namespace App\DataProvider;

use Iterator;
use ApiPlatform\Core\DataProvider\PaginatorInterface;
use ArrayIterator;

class CustomerPaginator implements \IteratorAggregate, PaginatorInterface
{
    private $_customers;
    private $_page;
    public function __construct($customers, $page)
    {
        $this->_customers = $customers;
        $this->_page = $page;
    }
    public function getLastPage(): float
    {
        return floor($this->getTotalItems() / $this->getItemsPerPage());
    }
    public function getTotalItems(): float
    {
        return $this->_customers->count();
    }
    public function getCurrentPage(): float
    {
        return $this->_page;
    }
    public function getItemsPerPage(): float
    {
        return 10;
    }
    public function count(): int
    {
        return $this->_customers->count();
    }
    public function getIterator(): Iterator
    {
        $array = [];
        $firstItemID = ($this->_page - 1) * $this->getItemsPerPage();
        for ($i=0;$i < $this->getItemsPerPage();$i++) {
            if (isset($this->_customers[$i + $firstItemID])) {
                $array[$i] = $this->_customers[$i + $firstItemID];
            } else {
                break;
            }
        }
        return new ArrayIterator($array);
    }
}
