<?php

interface Product
{
    public function getTotalPrice();

    public function getName();
}

abstract class Coffee implements Product
{
    protected $coef = 1;
    /**
     * @var Topping
     */
    protected $topping;

    public function setDouble()
    {
        $this->coef = 2;
    }


    public function getTotalPrice()
    {
        if ($this->topping) {
            return $this->topping->getPrice() + $this->getPrice() * $this->coef;
        }
        return $this->getPrice() * $this->coef;
    }

    public abstract function getName();

    public abstract function getPrice();

    public function addTopping(AbstractTopping $t)
    {
        $this->topping = $t;
    }
}

abstract class AbstractTopping
{
    public abstract function getPrice();
}

class Topping extends AbstractTopping
{
    public function getPrice()
    {
        return 2;
    }
}

class Chocolate extends AbstractTopping
{
    public function getPrice()
    {
        return 3;
    }
}

class Latte extends Coffee
{
    public function getPrice()
    {
        return 10;
    }

    public function getName()
    {
        return 'Latte';
    }
}

class Espresso extends Coffee
{
    public function getPrice()
    {
        return 6;
    }

    public function getName()
    {
        return 'Espresso';
    }
}

class Americano extends Coffee
{
    public function getPrice()
    {
        return 8;
    }

    public function getName()
    {
        return 'Americano';
    }
}

class Apple implements Product
{
    public function getTotalPrice()
    {
        return 5;
    }

    public function getName()
    {
        return 'Apple';
    }
}

class Check
{
    /**
     * @var Product[]
     */
    protected $list;

    public function add(Product $coffee)
    {
        $this->list[] = $coffee;
    }

    public function sum()
    {
        $sum = 0;
        foreach ($this->list as $item) {
            $totalPrice = $item->getTotalPrice();
            echo $item->getName() . ': ' . $totalPrice . '<br>';
            $sum += $totalPrice;
        }
        return $sum;
    }
}


$c = new Check;

$c->add(new Latte());

$latte = new Latte();
$latte->addTopping(new Chocolate());
$c->add($latte);

$coffee = new Americano();
$coffee->setDouble();
$c->add($coffee);

$c->add(new Apple());


echo 'Sum: ' . $c->sum();
