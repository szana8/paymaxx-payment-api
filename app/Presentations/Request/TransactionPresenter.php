<?php

namespace App\Presentations\Request;

class TransactionPresenter
{
    protected string $reference;

    protected string|null $description;

    protected int $amount;

    protected string|null $currency;

    protected array $lines;

    /**
     * @param string $reference
     * @param string $description
     * @param int $amount
     * @param string $currency
     * @param array $lines
     */
    public function __construct(string $reference, string|null $description, int $amount, string|null $currency, array $lines)
    {
        $this->reference = $reference;
        $this->description = $description;
        $this->amount = $amount;
        $this->currency = $currency;

        foreach ($lines as $line) {
            $this->lines[] = new TransactionLinePresenter(
                $line['name'],
                $line['category'],
                $line['brand'],
                $line['quantity'],
                $line['amount'],
            );
        }
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return array
     */
    public function getLines(): array
    {
        return $this->lines;
    }
}
