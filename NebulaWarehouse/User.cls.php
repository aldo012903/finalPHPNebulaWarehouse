<?php
class User{
    private $user_id;
    private $username;
    private $email;
    private $type;
    private $active;
    function __construct($user_id=null,$username=null,$email=null,$type=null,$active=null){
        $this->user_id=$user_id;
        $this->username=$username;
        $this->email=$email;
        $this->type=$type;
        $this->active=$active;
    }
    public function Update($connection) {
        
        $sqlCmd2="UPDATE Users SET username= '".$this->username."', email='".$this->email."', type='".$this->type."' where user_id = $this->user_id";
        
        $result2=$connection->query($sqlCmd2);
        if($result2==1) {
            return true;
        }else{
            return false;
        }
        
    }
    public function getById($connection, $user_id) {
        $sql = "SELECT * FROM Users WHERE user_id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            return null;
        }
        
        $row = $result->fetch_assoc();
        $user = new User();
        $user->setUser_id($row['user_id']);
        $user->setUsername($row['username']);
        $user->setEmail($row['email']);
        $user->setType($row['type']);
        $user->setActive($row['active']);
        return $user;
    }
    public function modifyUserPassword($connection, $user_id, $newPassword){
        $newPassword = md5($newPassword);
        $sqlCmd="update Users set password='$newPassword' where user_id=$user_id";
        $result=$connection->exec($sqlCmd);
        return $result;
    }
    public function deactive($connection){
        $user_id=$this->user_id;
        $sqlCmd="update Users set active='0' where user_id='$user_id'";
        $result=$connection->query($sqlCmd);
        if($result==1){
            $this->setActive(0);
        }
        return $result;
    }
    public function activate($connection){
        $user_id=$this->user_id;
        $sqlCmd="update Users set active='1' where user_id='$user_id'";
        $result=$connection->query($sqlCmd);
        if($result==1){
            $this->setActive(1);
        }
        return $result;
    }
    public function __call($method,$args){
        if($method="update"){
            $user_id=$this->user_id;
            $connection=$args[0];
            $opType=$args[1];
            switch ($opType){
                case 1:
                    $username=$this->username;
                    $sqlCmd="update Users set username='$username' where user_id=$user_id";
                    break;
                case 2:
                    $email=$this->email;
                    $sqlCmd="update Users set email='$email' where user_id=$user_id";
                    break;
                case 3:
                    $type=$this->type;
                    $sqlCmd="update Users set type='$type' where user_id=$user_id";
                    break;
            }
            $result=$connection->exec($sqlCmd);
            return $result;
        }
        
    }
    public function Create($connection, $pass){
        $username=$this->username;
        $email=$this->email;
        $type=$this->type;
        $active=$this->active;
        $pass= md5($pass);
        $sqlCmd="INSERT INTO Users(`username`, `email`, `password`, `type`, `active`) values ('$username','$email','$pass','$type','$active')";        
        try{
            $result=$connection->query($sqlCmd);
        }catch (Exception $e){
            return "0";
        }
        return $result;
    }
    public function getAllUsers($connection){
        $counter=0;
        $sqlStmt="Select * from Users";
        foreach ($connection->query($sqlStmt)as $oneRow){
            $user= new User();
            $user->setUser_id($oneRow["user_id"]);
            $user->setUsername($oneRow["username"]);
            $user->setEmail($oneRow["email"]);
            $user->setType($oneRow["type"]);
            $user->setActive($oneRow["active"]);
            $arrUsers[$counter++]=$user;
        }
        return $arrUsers ;
    }
    /**
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * @return string
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $user_id
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    /**
     * @param string $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }


}