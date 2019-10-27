<?php
  class AdminModel extends Model
  {
    public function getAdmin($admin)
    {
      // code...
      $errors= array();
      $query = "SELECT * FROM `admin` WHERE `login`='".$admin."'  limit 1";
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

    public function isPass($id)
    {
      try {
        $query = "UPDATE `tasks` SET `isPass` = ".$id['isPass']." WHERE `tasks`.`id` = ".$id['id'];
        $this->db->exec($query);
        return $id['isPass'];
      }
      catch (PDOException $e) {
        return $e;
      }
    }
    public function update($params)
    {
      // code...
      try {
        $id = $params['id'];
        $name = $params['name'];
        $email = $params['email'];
        $text = $params['text'];
        $query = "UPDATE `tasks` SET `name` = '".$name."', `email` = '".$email."', `text` = '".$text."',
        `isPass` = '1', `isChanged`= '1' WHERE `tasks`.`id` = ".$params['id'];
        $this->db->exec($query);
        echo "true";
      }
      catch (PDOException $e) {
        echo $e;
      }
    }

  }


 ?>
