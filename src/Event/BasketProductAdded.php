<?php

namespace App\Event;

use App\Entity\Customer;
use App\Entity\Product;
use Symfony\Component\EventDispatcher\Event;

## formulaire d'ajout d'un produit dans le panier d'utilisateur
class BasketProductAdded extends Event
{
    const NAME = 'basquet.product_added';
    private $product;
    private $customer;

    public function __construct(Product $product, Customer $customer)
    {
        $this->product = $product;
        $this->customer = $customer;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getCustomer()
    {
        return $this->customer;
    }
}