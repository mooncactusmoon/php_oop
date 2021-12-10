<?php

class DB{
    protected $table;
    protected $dsn="mysql:host=localhost;charset=utf8;dbname=track_expenses;";
    protected $pdo;

    public function __construct($table){
        $this->pdo=new PDO($this->dsn,'root','');
        $this->table=$table;

    }
    public function all(){
        //這裡的pdo沒有$，只有this有$
        $sql="select * from $this->table";
        // $rows=$this->pdo->query("select * from $this->table")->fetchAll(PDO::FETCH_ASSOC);
        $rows=$this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
}

$db=new DB('detail');
echo "<pre>";
print_r($db->all());
echo "</pre>";
?>