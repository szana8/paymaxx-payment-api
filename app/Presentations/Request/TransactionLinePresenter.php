<?php

namespace App\Presentations\Request;

class TransactionLinePresenter
{
    protected string $name;

    protected string $category;

    protected string $brand;

    protected int $amount;

    protected int $quantity;

    /**
     * @param string $name
     * @param string $category
     * @param string $brand
     * @param int $amount
     * @param int $quantity
     */
    public function __construct(string $name, string $category, string $brand, int $amount, int $quantity)
    {
        $this->name = $name;
        $this->category = $category;
        $this->brand = $brand;
        $this->amount = $amount;
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
