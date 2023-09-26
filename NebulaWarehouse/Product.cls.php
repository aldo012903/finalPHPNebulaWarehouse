<?php
class Product{
    private $product_id;
    private $product_name;
    private $description;
    private $price;
    function __construct($product_id=null,$product_name=null,$description=null,$price=null){
        $this->product_id=$product_id;
        $this->product_name=$product_name;
        $this->description=$description;
        $this->price=$price;
    }
    public function Update($connection) {
        
        $sqlCmd2="UPDATE products SET product_name= '".$this->product_name."', description='".$this->description."', price=$this->price where product_id = $this->product_id";
        
        $result2=$connection->query($sqlCmd2);
        if($result2==1) {
            return true;
        }else{
            return false;
        }
        
    }
    public function getById($connection, $product_id) {
        $sql = "SELECT * FROM Products WHERE product_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            return null;
        }
        $row = $result->fetch_assoc();
        $transaction = new Product();
        $transaction->setProduct_id($row['product_id']);
        $transaction->setProduct_name($row['product_name']);
        $transaction->setDescription($row['description']);
        $transaction->setPrice($row['price']);
        return $transaction;
    }
    public function delete($connection){
        $product_id=$this->product_id;
        $sqlCmd="SELECT SUM(total_count) as total
                 FROM (
                     SELECT COUNT(*) as total_count FROM Stock WHERE product_id = '$product_id'
                     UNION ALL
                     SELECT COUNT(*) as total_count FROM Transactions WHERE product_id = '$product_id'
                ) as t";
        $result=$connection->query($sqlCmd);
        $row = $result->fetch_assoc();
        if($row['total']!=0){
            return "Delete unsuccessfull the product with id: $product_id has stocks or/and transactions.";
        }
        $sqlCmd="delete from Products where product_id='$product_id'";
        $result=$connection->query($sqlCmd);
        if($result==1){
            return "Delete successfull";
        }
        return $result;
    }
    public function Create($connection){
        $product_name=$this->product_name;
        $description=$this->description;
        $price=$this->price;
        
        $sqlCmd="INSERT INTO Products(`product_name`, `description`, `price`) values ('$product_name','$description','$price')";
        try{
            $result=$connection->query($sqlCmd);
        }catch (Exception $e){
            return "0";
        }
        return $result;
    }
    public function getAllProducts($connection){
        $counter=0;
        $sqlStmt="Select * from Products";
        foreach ($connection->query($sqlStmt)as $oneRow){
            $product= new Product();
            $product->setProduct_id($oneRow["product_id"]);
            $product->setProduct_name($oneRow["product_name"]);
            $product->setDescription($oneRow["description"]);
            $product->setPrice($oneRow["price"]);
            $arrproducts[$counter++]=$product;
        }
        return $arrproducts ;
    }
    /**
     * @return string
     */
    public function getProduct_id()
    {
        return $this->product_id;
    }
    
    /**
     * @return string
     */
    public function getProduct_name()
    {
        return $this->product_name;
    }
    
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * @param string $product_id
     */
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;
    }
    
    /**
     * @param string $product_name
     */
    public function setProduct_name($product_name)
    {
        $this->product_name = $product_name;
    }
    
    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
}