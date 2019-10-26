<?php

class IndexModel extends Model
{
  public function getPage ()
  {
    return isset($_SESSION['page'])? $_SESSION['page'] :1;
  }

  public function getComm($page=1)
  {

    $_SESSION['page']= isset($page['page']) ? $page['page'] : 1;
    $sort=isset($page['sort']) ? $page['sort'] : 'date';
    $limit= isset($page['page']) ? $page['page'] : 5;
    $tpg=($limit-1)* 5 ;

    $query = 'SELECT * FROM `tasks` ORDER BY `date` ASC LIMIT '.$tpg.', 3';
    $comments = $this->db->query($query)->fetchAll();
    return $comments;
  }

  public function pagination()
  {

    $query = 'SELECT count(id) as count FROM `tasks` ';

    $pages = $this->db->query($query)->fetchAll();
    return $pages;
  }

  public function save($params)
  {
    // code...
    try {
      $name = htmlspecialchars($params['name']);
      $email = htmlspecialchars($params['email']);
      $text = htmlspecialchars($params['text']);
      $safe = $this->db->prepare("INSERT INTO `tasks` SET name= :name, email= :email,
        text= :text, date=CURRENT_TIMESTAMP, isPass='0' ");
        $arr= ['name'=> $name, 'email'=> $email, 'text'=> $text];
        $safe->execute($arr);
        return "true";
      }
      catch (PDOException   $e) {
        return $e;
      }
    }

    public function isPass($id)
    {
      try {
        $query = "UPDATE `tasks` SET `isPass` = ".$id['isPass']." WHERE `tasks`.`id` = ".$id['id'];
        $this->db->exec($query);
        return "true";
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
