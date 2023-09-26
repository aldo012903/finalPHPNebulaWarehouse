<?php
class Stock{
    private $stock_id;
    private $product_id;
    private $quantity;
    private $update_time;
    function __construct($stock_id=null, $product_id=null, $quantity=null, $update_time=null){
        $this->stock_id=$stock_id;
        $this->product_id=$product_id;
        $this->quantity=$quantity;
        $this->update_time=$update_time;
    }
    public function Create($connection){
        $product_id=$this->product_id;
        $quantity=$this->quantity;
        $update_time=$this->update_time;
        $sqlCmd="INSERT INTO Stock(`product_id`, `quantity`, `update_time`) values ('$product_id','$quantity','$update_time')";
        try{
            $result=$connection->query($sqlCmd);
        }catch (Exception $e){
            return "0";
        }
        return $result;
    }
    public function Update($connection) {
        echo $this->stock_id;
        $sqlCmd2="UPDATE Stock SET quantity= '".$this->quantity."', update_time='".$this->update_time."' where stock_id = $this->stock_id";
        
        $result2=$connection->query($sqlCmd2);
        echo"aqui";
        
        if($result2==1) {
            return true;
        }else{
            return false;
        }
        
    }
    public function getById($connection, $stock_id) {
        $sql = "SELECT * FROM Stock WHERE stock_id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $stock_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            return null;
        }   
        
        $row = $result->fetch_assoc();
        $stock = new Stock();
        $stock->setStock_id($row['stock_id']);
        $stock->setProduct_id($row['product_id']);
        $stock->setQuantity($row['quantity']);
        $stock->setUpdate_time($row['update_time']);
        return $stock;
    }
    public function delete($connection){
        $stock_id = $this->stock_id;
        
        $sqlCmd = "DELETE FROM Stock WHERE stock_id = '$stock_id'";
        $result = $connection->query($sqlCmd);
        if($result == 1){
            return "Delete successfull";
        }
        return $result;
    }
    public function getAllStocks($connection){
        $counter=0;
        $sqlStmt="Select * from Stock";
        foreach ($connection->query($sqlStmt)as $oneRow){
            $stock= new Stock();
            $stock->setStock_id($oneRow["stock_id"]);
            $stock->setProduct_id($oneRow["product_id"]);
            $stock->setQuantity($oneRow["quantity"]);
            $stock->setUpdate_time($oneRow["update_time"]);
            $arrStock[$counter++]=$stock;
        }
        return $arrStock ;
    }
    /**
     * @return mixed
     */
    public function getStock_id()
    {
        return $this->stock_id;
    }

    /**
     * @return mixed
     */
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return mixed
     */
    public function getUpdate_time()
    {
        return $this->update_time;
    }

    /**
     * @param mixed $stock_id
     */
    public function setStock_id($stock_id)
    {
        $this->stock_id = $stock_id;
    }

    /**
     * @param mixed $product_id
     */
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @param mixed $update_time
     */
    public function setUpdate_time($update_time)
    {
        $this->update_time = $update_time;
    }
}
