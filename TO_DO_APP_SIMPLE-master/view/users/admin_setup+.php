<div class="col shadow main-col bg-white">
  <div class="row bg-primary text-white">
    <div class="col  p-2">
      <h4>
        <?php echo LANG_APP_NAME;?>
      </h4>
    </div>
    <div class="col">
      <div class="float-right p-2">
      <a href="index.php?action=logout"><b style="color:white;">Logout</b></a>
      </div>
    </div>
  </div>
  
  <!-- <div class="row" id="todo-container"> -->

  <div class="col col-12 p-2 todo-item" todo-id="${todo.id}">
        <div class="form-control ">
            <label><?php echo LANG_TOTAL_NON_ADMIN;?></label>
            <label><?php echo count($users);?></label>
        </div>

    </div>

    <div class="col col-12 p-2 todo-item" todo-id="${todo.id}">
        <div class="form-control ">
            <label><?php echo LANG_TOTAL_TASKS;?></label>
            <label><?php echo count($items);?></label>
        </div>

    </div>

  <div class="col col-12 p-2 todo-item" todo-id="${todo.id}">
        <div class="form-control ">
            <label><?php echo LANG_ALL_NON_ADMIN_USERS;?></label>
        </div>

    </div>


    <?php 
    for ($j=0;$j<count($users);$j++){
            ?>

    <div class="col col-12 p-2 todo-item" todo-id="${todo.id}">
      <div class="input-group">
        <input type="text" readonly class="form-control "
          value="<?php echo htmlspecialchars($users[$j]['name']);?>">
        <input type="text" readonly class="form-control "
          value="<?php echo htmlspecialchars($users[$j]['email']);?>">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary bg-danger text-white" type="button" id="button-addon2"
            onclick="location='index.php?action=admin_block&user_id=<?php echo $users[$j]['user_id'];?>'"><?php echo LANG_BLOCK;?></button>
        </div>
      </div>
    </div>

    <?php
            }
          ?>


    <div class="col col-12 p-2 todo-item" todo-id="${todo.id}">
        <div class="form-control ">
            <label><?php echo LANG_ALL_TODO_TASKS;?></label>
        </div>

    </div>
    <?php 
    for ($i=0;$i<count($items);$i++){
            ?>

    <div class="col col-12 p-2 todo-item" todo-id="${todo.id}">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <input type="checkbox">
          </div>
        </div>
        <input type="text" readonly class="form-control " aria-label="Text input with checkbox"
          value="<?php echo htmlspecialchars($items[$i]['title']);?>">
        <div class="input-group-append">
          <button class="btn  text-black" type="button" id="button-addon2"
            onclick="location='index.php?action=do_edit&item_id=<?php echo $items[$i]['item_id'];?>&title=<?php echo $title;?>'">edit</button>
          <button class="btn btn-outline-secondary bg-danger text-white" type="button" id="button-addon2"
            onclick="location='index.php?action=admin_delete&item_id=<?php echo $items[$i]['item_id'];?>'">X</button>
        </div>
      </div>
    </div>

    <?php
            }
          ?>

<button type="submit" class="btn btn-primary mb-2 ml-2" onclick="location='index.php?'">
        <?php echo LANG_EXIT;?>
      </button>
      </div>