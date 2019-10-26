<?php
  class AdminModel extends Model
  {
    public function getAdmin()
    {
      // code...
      $errors= array();
      $query = "SELECT * FROM `admin` WHERE `login`='".$_POST['params']['admin']."'  limit 1";
      $user= $this->db->query($query)->fetchAll();
      return $user;
    }
    public function isLog()
    {
      // code...
      if(isset($_SESSION['logged_user']))
      {
        echo "true";
        return true;
      }
			else{
        echo "nothing";
        return false;
      }
    }

  }


 ?>
