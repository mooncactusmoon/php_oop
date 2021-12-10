<?php
interface sound{
    public function sound();
}

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
    public function sound(){
        return "helloooo";
    }
    public function getName(){
        return $this->name;
    }
    public function getHeartbeat(){
        return $this->heartbeat;
    }
    public function setName($name){
        $this->name=$name;
    }
}

/**$animal=new Animal;
echo $animal->getName();
echo "<br>";
$animal->setName('YOYO');
echo $animal->getName();
echo "<br>";
echo $animal->getHeartbeat();
echo "<hr>";
$dog=new Animal;
$dog->setName('herry');
echo $dog->getName();**/

class Dog extends Animal{
    protected $hair_color="black";


    public function getColor(){
        return $this->hair_color;
    }
    public function setColor($color){
        return $this->hair_color=$color;
    }
    public function sound(){
        return "汪汪叫";
    }

    //複寫
    public function getName(){
        return 'my name is '.$this->name;
    }

}
class Cat extends Animal{
    protected $hair_color="black";


    public function getColor(){
        return $this->hair_color;
    }
    public function setColor($color){
        return $this->hair_color=$color;
    }
    public function sound(){
        return "喵喵叫";
    }

    //複寫
    public function getName(){
        return 'I am '.$this->name;
    }

}

$dog=new Dog;
echo $dog->getName();
echo "<br>";
$dog->setName('make');
echo $dog->getName();
echo "<br>";
echo $dog->getColor();
echo "<br>";
echo $dog->sound();
echo "<hr>";

$cat=new Cat;
echo $cat->getName();
echo "<br>";
$cat->setName('JJ');
echo $cat->getName();
echo "<br>";
echo $cat->getColor();
echo "<br>";
echo $cat->sound();

echo "<hr>";
$animal=new Animal;
echo $animal->sound();
?>