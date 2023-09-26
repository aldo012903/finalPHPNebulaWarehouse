<?php

class Transaction{
    private $transaction_id;
    private $user_id;
    private $product_id;
    private $quantity;
    private $transaction_time;
    function __construct($transaction_id=null,$user_id=null,$product_id=null,$quantity=null,$transaction_time=null){
        $this->transaction_id=$transaction_id;
        $this->user_id=$user_id;
        $this->product_id=$product_id;
        $this->quantity=$quantity;
        $this->transaction_time=$transaction_time;
    }
    public function Update($connection) {
        $sqlStmt="Select * from stock where product_id = $this->product_id";
        $val = 0;
        foreach ($connection->query($sqlStmt)as $oneRow){
            $val = $oneRow["quantity"];
        }
        
        $sqlStmt_="Select * from Transactions WHERE transaction_id=$this->transaction_id";
        $val_anterior = 0;
        foreach ($connection->query($sqlStmt_)as $oneRow){
            $val_anterior = $oneRow["quantity"];
        }
        
        $realVal2 = $val-($this->quantity-$val_anterior);
        
        if ($realVal2>=0) {
            
            $sqlCmd="UPDATE Transactions SET user_id= $this->user_id, product_id=$this->product_id, quantity=$this->quantity, transaction_time='".$this->transaction_time."' WHERE transaction_id=$this->transaction_id";
            $result=$connection->query($sqlCmd);
            
            if($result==1) {
                $sqlCmd2="UPDATE stock SET quantity= $realVal2 where product_id = $this->product_id";
                $result2=$connection->query($sqlCmd2);
                if($result2==1) {
                    return true;
                }else{
                    return false;
                }
            } else {
                return false;
            }
        }else{
            return false;
        }
        
    }
    public function Create($connection){
        $user_id=$this->user_id;
        $product_id=$this->product_id;
        $quantity=$this->quantity;
        $transaction_time=$this->transaction_time; 
        
        $stmt = $connection->prepare("SELECT count(*) FROM Stock WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);        
        $stmt->execute();        
        $stmt->bind_result($countExist);        
        $stmt->fetch();
        $stmt->close();
        if($countExist==0){
            return "Product id doesnt exist.";
        }
        
        $stmt = $connection->prepare("SELECT quantity FROM Stock WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->bind_result($quantityNew);
        $stmt->fetch();
        $stmt->close();
        
        if($quantityNew-$quantity<0){
            return "Not enough quantity in stock";
        }
        $quantityNew = $quantityNew-$quantity;
        $sqlCmd="UPDATE Stock set quantity='$quantityNew' where product_id ='$product_id'";
        $result=$connection->query($sqlCmd);
        $sqlCmd="INSERT INTO Transactions(`user_id`, `product_id`, `quantity`, `transaction_time`) values ('$user_id','$product_id','$quantity','$transaction_time')";
        try{
            $result=$connection->query($sqlCmd);
        }catch (Exception $e){
            return "Error in the information provided.";
        }
        return $result;
    }
    public function getById($connection, $transaction_id) {
        $sql = "SELECT * FROM Transactions WHERE transaction_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $transaction_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            return null;
        }
        $row = $result->fetch_assoc();
        $transaction = new Transaction();
        $transaction->setTransaction_id($row['transaction_id']);
        $transaction->setUser_id($row['user_id']);
        $transaction->setProduct_id($row['product_id']);
        $transaction->setQuantity($row['quantity']);
        $transaction->setTransaction_time($row['transaction_time']);
        return $transaction;
    }
    public function getAllTransactions($connection){
        $counter=0;
        $sqlStmt="Select * from Transactions";
        foreach ($connection->query($sqlStmt)as $oneRow){
            $transaction= new Transaction();
            $transaction->setTransaction_id($oneRow["transaction_id"]);
            $transaction->setUser_id($oneRow["user_id"]);
            $transaction->setProduct_id($oneRow["product_id"]);
            $transaction->setQuantity($oneRow["quantity"]);
            $transaction->setTransaction_time($oneRow["transaction_time"]);
            $arrUsers[$counter++]=$transaction;
        }
        return $arrUsers ;
    }
    /**
     * @return mixed
     */
    public function getTransaction_id()
    {
        return $this->transaction_id;
    }

    /**
     * @return mixed
     */
    public function getUser_id()
    {
        return $this->user_id;
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
    public function getTransaction_time()
    {
        return $this->transaction_time;
    }

    /**
     * @param mixed $transaction_id
     */
    public function setTransaction_id($transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
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
     * @param mixed $transaction_time
     */
    public function setTransaction_time($transaction_time)
    {
        $this->transaction_time = $transaction_time;
    }

    
}