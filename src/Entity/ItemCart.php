<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class ItemCart
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $prices = [];

    public function addPrice(array $price): void
    {
        $this->validatePrice($price);
        $this->prices[] = $price;
    }

    private function validatePrice(array $price): void
    {
        if (!array_key_exists('amount', $price) && !array_key_exists('currency', $price)) {
            throw new \RuntimeException('Price muse have keys "amount" and "currency"');
        }
    }
}
