<?php

namespace App\Models;

use Exception;

class Money
{
    private string $amount;

    private Currency $currency;

    public function __construct(int|string $amount, Currency $currency)
    {
        $this->currency = $currency;

        if (is_string($amount)) {
            $this->checkStringMoney($amount);
            $this->amount = $amount;
        }else {
            if ($amount < 1){
                throw new Exception('Amount must be at least 1');
            }

            if ($amount > 100){
                $this->amount = (string) $amount/100;
            }else {
                $this->amount = (string) '0.'.$amount;
            }
        }
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function sameCurrencyCheck(Money $other)
    {
        if ($this->currency != $other->currency){
            throw new Exception('Currency must be the same');
        }
    }

    public function greaterCheck(Money $other)
    {
        if (!$this->greater($other)){
            throw new Exception('First amount must be greater than second');
        }
    }

    public function checkStringMoney(string $value)
    {
        if (!preg_match('/^\d+(\.\d{2})?$/', $value))
        {
            throw new Exception('Write a real number with 2 decimal places after dot');
        }

        if ($value == '0'){
            throw new Exception('Number can\'t be 0');
        }
    }

    public function equals(Money $other): bool
    {
        $this->sameCurrencyCheck($other);
        return bccomp($this->amount, $other->amount, 2) === 0;
    }

    public function greater(Money $other): bool
    {
        $this->sameCurrencyCheck($other);
        return bccomp($this->amount, $other->amount, 2) > 0;
    }

    public function add(Money $other): Money
    {
        $this->sameCurrencyCheck($other);
        $newValue = bcadd($this->amount, $other->amount, 2);

        return new Money($newValue, $this->currency);
    }

    public function subtract(Money $other): Money
    {
        $this->greaterCheck($other);
        $newValue = bcsub($this->amount, $other->amount, 2);

        return new Money($newValue, $this->currency);
    }

    public function multiply(string $number): Money
    {
        $this->checkStringMoney($number);

        $newValue = bcmul($this->amount, $number, 2);

        return new Money($newValue, $this->currency);
    }

    public function divide(string $number): Money
    {
        $this->checkStringMoney($number);

        $newValue = bcdiv($this->amount,$number, 2);

        return new Money($newValue, $this->currency);
    }

}
