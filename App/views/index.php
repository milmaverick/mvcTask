<?php
if (isset($pageData)){
  if(isset($_SESSION['logged_user'])){

    foreach ($pageData as $comment) {
      ?>
      <div class='comment <?if ($comment['isPass']==1) echo "deleteElement";?>'  id="comment<?=$comment['id']?>">
        <div class="media">
          <div class="media-body">
            <div class="task_inner">
              <div class="head__tasks">
                <div class="name" id="name<?=$comment['id']?>">ИМЯ: <?=$comment['name']?></div>
                <div class="email" id="email<?=$comment['id']?>">EMAIL: <?=$comment['email']?></div>
              </div>
              <div class="options">
                <span class='res isChanged <?if ($comment['isChanged']==0) echo "displayNone";?>'> Изменен Админом</span>
                <span class='res isPass'>
                  <input class="checkBox" id="check<?=$comment['id']?>" type="checkbox" name="check" value="0" <? if($comment['isPass']==1) echo "checked"; ?>>
                  <label for="check<?=$comment['id']?>"></label>
                </span>
                <span class='res resChange'  data-toggle="modal" data-target="#exampleModal" id='change<?=$comment['id']?>'>
                  <a href='#' onclick='changeElement(<?=$comment['id']?>)'> Изменить</a>
                </span>
              </div>
            </div>


            <div class="text"  id="text<?=$comment['id']?>">TEXT: <?=$comment['text']?></div>

            <br>
          </div>
        </div>
      </div>
    <?	}
  }
  else{
    foreach ($pageData as $comment) {
      ?>
      <div class="comment">
        <div class="media">
          <div class="media-body">
            ИМЯ: <?=$comment['name']?>  |  email: <?=$comment['email']?>
            <div class="options">
              <span class='res isChanged <?if ($comment['isChanged']==0) echo "displayNone";?>'> Изменен Админом</span>
              <span class='res resReturn <?if ($comment['isPass']==0) echo "displayNone";?>' > Выполнено</span>
            </div>
            <br> TEXT: <?=$comment['text']?>

          </div>
        </div>
      </div>
    <?	}
  }
}
?>
