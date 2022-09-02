<?php
require 'db.con.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do App</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="main-section">
        <div class="add-section">
            <form action="app/add.php" method="POST" autocomplete="off">
                <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error') { ?>
                    <input type="text"
                        name="title"
                        style="border-color: #ff6666"
                        placeholder="This field is required" /> <br>
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>
                <?php }else { ?>
                    <input type="text"
                            name="title"
                            placeholder="What do you need to do?" /> <br>
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>
                <?php }?>
            </form>
        </div>

        <!-- get all the data from the todo table -->
        <?php
            $todo = $conn->query("SELECT * FROM todo ORDER BY id DESC");
        ?>
        <div class="show-todo-section">
            <?php if($todo->rowCount() <= 0) { ?>    
                <div class="todo-item"> 
                        <div class="empty">
                            <img src="img/todo.png" width="100%" />
                        </div>
                </div> 
            <?php } ?>

            <?php while($to_do = $todo->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                        <span id="<?php echo $to_do['id']; ?>" 
                            class="remove-to-do">x</span>

                        <?php if($to_do['checked']) { ?>
                            <input type="checkbox"
                                    class="check-box"
                                    data-todo-id ="<?php echo $to_do['id']; ?>"
                                    checked />
                            <h2 class="checked"><?php echo $to_do['title'] ?></h2>
                        <?php }else { ?>
                            <input type="checkbox"
                                    data-todo-id ="<?php echo $to_do['id']; ?>"
                                    class="check-box" />
                            <h2><?php echo $to_do['title'] ?></h2>
                        <?php } ?>
                        <br>
                        <small>created: <?php echo $to_do['date_time'] ?></small>
                </div>
            <?php } ?>       
        </div>
    </div>
    
    <script src="js/jquery-3.6.1.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');
                
                $.post("app/remove.php", 
                      {
                          id: id
                      },
                      (data)  => {
                         if(data){
                             $(this).parent().hide(600);
                         }
                      }
                );
            });

            $(".check-box").click(function(e){
                const id = $(this).attr('data-todo-id');
                
                $.post('app/check.php', 
                      {
                          id: id
                      },
                      (data) => {
                          if(data != 'error'){
                              const h2 = $(this).next();
                              if(data === '1'){
                                  h2.removeClass('checked');
                              }else {
                                  h2.addClass('checked');
                              }
                          }
                      }
                );
            });
        });
    </script>
</body>
</html>