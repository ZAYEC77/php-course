<?php


//Part 1

interface WritableInterface
{
    public function write(User $u);
}


class User
{
    public $name;

    public function save(WritableInterface $w)
    {
        $w->write($this);
    }
}

// Part 1


// Part 2

class FileWrite implements WritableInterface
{
    public function write(User $u)
    {
        file_put_contents('users.txt', $u->name);
    }
}

$u = new User();
$writer = new FileWrite();

$u->save($writer);



//Part 3

class DbWrite implements WritableInterface {
    public function write(User $u)
    {
        $sql = "INSERT INTO user";

        ///
    }
}


$u = new User();
$writer = new DbWrite();

$u->save($writer);




