<?php

class DB{
    protected $table;
    protected $dsn="mysql:host=localhost;charset=utf8;dbname=track_expenses;";
    protected $pdo;

    public function __construct($table){
        $this->pdo=new PDO($this->dsn,'root','');
        $this->table=$table;

    }
    public function all(...$arg){
        //這裡的pdo沒有$，只有this有$
        $sql="select * from $this->table";

                //依參數數量來決定進行的動作因此使用switch...case
                switch(count($arg)){
                    case 1:
                
                        //判斷參數是否為陣列
                        if(is_array($arg[0])){
                
                            //使用迴圈來建立條件語句的字串型式，並暫存在陣列中
                            foreach($arg[0] as $key => $value){
                
                                $tmp[]="`$key`='$value'";
                
                            }
                
                            //使用implode()來轉換陣列為字串並和原本的$sql字串再結合
                            $sql.=" WHERE ". implode(" AND " ,$tmp);
                        }else{
                            
                            //如果參數不是陣列，那應該是SQL語句字串，因此直接接在原本的$sql字串之後即可
                            $sql.=$arg[0];
                        }
                    break;
                    case 2:
                
                        //第一個參數必須為陣列，使用迴圈來建立條件語句的陣列
                        foreach($arg[0] as $key => $value){
                
                            $tmp[]="`$key`='$value'";
                
                        }
                
                        //將條件語句的陣列使用implode()來轉成字串，最後再接上第二個參數(必須為字串)
                        $sql.=" WHERE ". implode(" AND " ,$tmp) . $arg[1];
                    break;
                
                    //執行連線資料庫查詢並回傳sql語句執行的結果
                    }
                
                    //fetchAll()加上常數參數FETCH_ASSOC是為了讓取回的資料陣列中
                    //只有欄位名稱,而沒有數字的索引值
                   // echo $sql;
        
        $rows=$this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    //只取一筆
    public function find($id){
        $sql="SELECT * FROM $this->table WHERE ";
        if(is_array($id)){

            foreach($id as $key => $value){
                $tmp[]="`$key`='$value'";
            }

            $sql .= implode(' AND ',$tmp);

        }else{
            //$sql = $sql . "" 可寫成 $sql .= (累加)
            $sql .= " id='$id'";
        }

        //echo $sql;

        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    //計算某個欄位或是計算符合條件的筆數
    //max,min,sum,count,avg
    public function math($math,$col,...$arg){
        $sql="SELECT $math($col) FROM $this->table ";
        //依參數數量來決定進行的動作因此使用switch...case
        switch(count($arg)){
            case 1:
                if(is_array($arg[0])){
                    foreach($arg[0] as $key => $value){
                        $tmp[]="`$key`='$value'";
                    }
                    $sql.=" WHERE ". implode(" AND " ,$tmp);
                }else{    
                    $sql.=$arg[0];
                }
            break;
            case 2:
                foreach($arg[0] as $key => $value){
                    $tmp[]="`$key`='$value'";
                }
                $sql.=" WHERE ". implode(" AND " ,$tmp) . $arg[1];
            break;
            }
            echo $sql;
            return $this->pdo->query($sql)->fetchColumn();
    }

    //新增或更新資料 (一定要是陣列) 僅限一次一筆資料
    public function save($array){
        if(isset($array['id'])){
            //update
            foreach($array as $key => $value){
                //優雅寫法 sprint_f("`%s`='%s'",$key,$value) %s代表字串
                if($key!='id'){//$key的判斷可加可不加，結果一樣，但程式碼有潔癖的建議加上
                    $tmp[]="`$key`='$value'"; //暴力寫法
                }
            }
            $sql="UPDATE $this->table SET ".implode(" , ",$tmp);
            $sql .= " WHERE `id`='{$array['id']}'";
            
            //UPDATE $this->table SET col1=value1,col=value2...where id=? && col1=value1
        }else{
            //insert
            
            // $keys=array_keys($array);
            // $cols=implode("`,`",$keys);
            // $values=implode("','",$array);
            // echo $cols."<br>";
            // echo $values."<br>";
            // $sql="INSERT INTO $this->table (`{$cols}`) VALUE('{$values}')";
            
            $sql="INSERT INTO $this->table (`".implode("`,`",array_keys($array))."`)
                                    VALUE('".implode("','",$array)."')";
            
            //INSERT INTO $this->table(`col1`,`col2`,`col3`...)VALUES('value1','value2','value3'...)
        }

        // echo $sql;
        return $this->pdo->exec($sql);

    }

    //刪除資料

    public function del($id){
        $sql="DELETE FROM $this->table WHERE ";
        if(is_array($id)){

            foreach($id as $key => $value){
                $tmp[]="`$key`='$value'";
            }

            $sql .= implode(' AND ',$tmp);

        }else{
            //$sql = $sql . "" 可寫成 $sql .= (累加)
            $sql .= " id='$id'";
        }

        //echo $sql;

        return $this->pdo->exec($sql);
    }

    //萬用的查詢
    public function q($sql){
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }



}

$db=new DB('detail');
// echo "<pre>";
//沒有id就會變新增
// print_r($db->save(['cash'=>120,'place'=>'eat']));
// echo "</pre>"; 
// echo "<pre>";
//有id就是update
// print_r($db->save(['id'=>4,'cash'=>7850,'place'=>'PCHome web']));
// echo "</pre>"; 
// echo "<pre>";
// print_r($db->q("select * from `detail` where `cash`<=100"));
// echo "</pre>"; 
// echo "<pre>";
// print_r($db->del(15));
// echo "</pre>"; 
// echo "<pre>";
// print_r($db->math('sum','cash',['item'=>'早餐']));
// echo "</pre>"; 
// echo "<pre>";
// print_r($db->math('max','cash',['item'=>'早餐']));
// echo "</pre>"; 
// echo "<pre>";
// print_r($db->all(['cash'=>'500']));
// echo "</pre>";
?>