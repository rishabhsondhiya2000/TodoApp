<?php
  $conn=mysqli_connect("localhost","root","","user_info");
  $error='';
  if(isset($_POST['add'])){
      
      $textbox=$_POST['textbox'];
      if($textbox==''){
          $error="No blank values is allowed";
      }
      else{
      $insert="insert into todo(title) values('$textbox')";
      mysqli_query($conn,$insert);
      }
  }
  if(isset($_GET['delete'])){
      $id=$_GET['delete'];
      $delete="delete from todo where id='$id'";
      mysqli_query($conn,$delete);
      header("location:index.php");
  }
  if(isset($_POST['update'])){
      $id=$_POST['id'];
      $text=$_POST['text'];
      $update="update todo SET title='$text' where id='$id'";
      mysqli_query($conn,$update);
      header("location:index.php");
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
     <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
</head>

<body>
    <div class="box">
    <h2 id="heading">My ToDo List</h2>
        <div class="add-box">
            <form action="" method="POST">
            <input id="textbox" name="textbox" type="text" placeholder="What to do next ?">
            <button id="add" type="submit" name="add">ADD</button>
        </form>
        </div>
        <div class="show-box">
            <ul class="list">
                <?php
                   echo $error;
                  $sql="select * from todo order by id desc";
                  $res=mysqli_query($conn,$sql);
                   $count=mysqli_num_rows($res);
                  if($count==0){echo"No Data is found";}
                  else{
                  while($row=mysqli_fetch_assoc($res)){
                      $input_id='input'.$row['id'];
                      $upd_id='upd'.$row['id'];
                ?>
                <li id='list<?php echo $row['id']?>'> <input type="checkbox" id='check<?php echo $row['id']?>'  onclick="disable('<?php echo $row['id']?>')">
                    <form class="form1" action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']?>">
                        <input  name='text' id='<?php echo $input_id; ?>'  type="text" value="<?php echo $row['title']?>" class="title" readonly>
                        <button type='submit' id='<?php echo $upd_id; ?>' name='update'  class="update">
                            <img src="images/check.png" alt="">
                        </button>
                    </form>
                    <button onclick="editable('<?php echo $input_id; ?>','<?php echo $upd_id; ?>')"  class="edit">
                        <img src="images/pencil.png" alt="">
                    </button>
                    <a href="index.php?delete=<?php echo $row['id']?>" class="delete">
                           <img src="images/cross.png" alt="">
                    </a>
            </li>

                  <?php } }?> 
            </ul>
        </div>
    </div>
    <script>
             function editable(input_id,upd_id){
                 let field=document.getElementById(''+input_id);
                 field.readOnly=false;
                 field.style.borderBottom="1px solid black";
                 field.style.padding="3px";
                 
                 document.getElementById(''+upd_id).style.display="block";
             }

             function disable(id){
                 let abc=document.getElementById('check'+id);
                 
                 if(abc.checked==true){
                    let abcd=document.getElementById('input'+id);
                    abcd.disabled=true;
                    
                    
                 }
                 else{
                    let abcd=document.getElementById('input'+id);
                    abcd.disabled=false;
                    
                 }
             }
             

    </script>
</body> 

</html>
