<?php

interface InfoInterface
{
    public function info();
}
abstract class Figure implements InfoInterface
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function info()
    {
        echo "My name is: {$this->name} <br>My square is: {$this->s()}<br>";
    }
}
class Triangle extends Figure
{
    protected $a;
    protected $b;
    protected $c;

    public function __construct($name, $a, $b, $c)
    {
        parent::__construct($name);
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    public function s()
    {
        $p = $this->p() / 2;
        return sqrt(($p - $this->a) * ($p - $this->b) * ($p - $this->c));
    }

    public function p()
    {
        return $this->a + $this->b + $this->c;
    }


}
class Square extends Figure
{
    protected $a;

    public function __construct($name, $a)
    {
        parent::__construct($name);
        $this->setA($a);
    }

    public function setA($value)
    {
        if ($value <= 0) {
            echo $value . ' must be great then 0';
        }
        $this->a = $value;
    }

    public function s()
    {
        return $this->a * $this->a;
    }
}
class Rect extends Square
{
    private $b;

    public function __construct($name, $a, $b)
    {
        parent::__construct($name, $a);
        $this->setB($b);
    }

    public function setB($value)
    {
        if ($value <= 0) {
            echo $value . ' must be great then 0';
        }
        $this->b = $value;
    }

    public function s()
    {
        return $this->a * $this->b;
    }
}

class Logger
{
    public function log(InfoInterface $obj)
    {
        $obj->info();
        echo '<br>';
    }
}

class User implements InfoInterface
{
    public function info()
    {
        echo "Hello I'm User";
    }

}


$list = [
    new Rect('R1', 3, 4),
    new Square('S1', 3),
    new Square('S2', 6),
    new Triangle('Tr1', 3, 4, 5),
    new User(),
//    34,
];

$l = new Logger();

foreach ($list as $item) {
    $l->log($item);
}


