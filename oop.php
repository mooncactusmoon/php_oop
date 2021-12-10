<?php
//宣告類別(樣本概念)
//public外部可存取，protected private外部無法存取
class Animal{
    protected $name=''; 
    protected $age=0; 
    private $heartbeat=0;

    public function __construct(){
        $this->age=rand(10,20);
        $this->name='john';
        $this->heartbeat=rand(20,60);

    }
    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name=$name;
    }
}

$animal=new Animal;

echo $animal->getName();
$animal->setName('YOYO');
echo $animal->getName();


?>