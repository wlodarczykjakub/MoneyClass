<?php

namespace Tests\Unit;

use App\Models\Currency;
use App\Models\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function test_money_construct()
    {
        $eur = new Currency('EUR');
        $usd = new Currency('USD');
        $money1 = new Money('55.22',$eur);
        $money2 = new Money(87,$usd);
        $this->assertTrue(true);
    }

    public function test_money_equals()
    {
        $eur = new Currency('EUR');
        $money1 = new Money('5.55',$eur);
        $money2 = new Money(555,$eur);
        $this->assertTrue($money1->equals($money2));
    }

    public function test_money_add()
    {
        $eur = new Currency('EUR');
        $money1 = new Money(87,$eur);
        $money2 = new Money(555,$eur);
        $resultMoney = $money1->add($money2);
        $this->assertSame('6.42', $resultMoney->getAmount());
    }

    public function test_money_subtract()
    {
        $eur = new Currency('EUR');
        $money1 = new Money(555,$eur);
        $money2 = new Money(87,$eur);
        $resultMoney = $money1->subtract($money2);
        $this->assertSame('4.68', $resultMoney->getAmount());
    }

    public function test_money_multiply()
    {
        $eur = new Currency('EUR');
        $money1 = new Money(87,$eur);
        $resultMoney = $money1->multiply('2.04');
        $this->assertSame('1.77', $resultMoney->getAmount());
    }

    public function test_money_divide()
    {
        $eur = new Currency('EUR');
        $money1 = new Money(87,$eur);
        $resultMoney = $money1->divide('3');
        $this->assertSame('0.29', $resultMoney->getAmount());
    }
}
