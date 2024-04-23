
<!--                                                                                 -->

<?php
include "all.php";
try{
$con =new PDO("$sql",$user,$pass);
$select = $con->prepare("SELECT * from $tbname");
$select->execute();
$fetchAll = $select->fetchAll();
}catch(PDOException $e){
    echo "note conetc".$e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            display: flex;
            justify-content: center;
        }
        tr{
            border: 2px solid black;
        }
        th , td{
            border: 2px solid black;
            text-align: center;
        }
        input{
            text-align: center;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>ID</th><th>USER NAME</th><th>EMAIL</th><th>PASSWORD</th><th>EDIT</th><th>DELETE</th><th><a href="add.html">ADD</a></th>
        </tr>
        <?php 
        foreach($fetchAll as $v){
        ?>
     
        <tr>
            <form action="" method="post">
            <td><input type="text" name="id" value=" <?php echo $v["id"]; ?>"></td>
            <td><input type="text" name="username" value="<?php echo $v["username"]; ?>"> </td>
            <td><input type="text" name="email" value="<?php echo $v["email"]; ?>"> </td>
            <td><input type="text" name="password" value=" <?php echo $v["password"]; ?>"></td>
            <td><input type="submit" name="edit" id="editsubmit" value='edit'></td>
            <td><input type="submit" name="delete<?php echo $v["id"]; ?>" id="deletesubmit" value='delete'></td>
            </form>
        </tr>

        <?php 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(!empty($_POST["username"])){
       $username =filter($_POST["username"]);

         if(!empty($_POST["email"])){
            $email =filter($_POST["email"]);

            if(!empty($_POST["password"])){
               $password =filter($_POST["password"]); 
                try{
                    $connect =new PDO("$sql",$user,$pass);
                    $connect->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
            
            
                    $selected = $connect->prepare("SELECT email FROM $tbname WHERE email='$email'");
                    $selected->execute();
                    $slt = $selected->fetch();

                 
                 

                    if ($slt && $email == $slt['email']) {echo "alreadyemail";} else {echo "editemail";}
                    
                    if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){echo "bademail";}else{

                        
                                /////////////////////////////
                                if(isset($_POST["edit"])){
                                    $id =filter($_POST["id"]);
                                    $username =filter($_POST["username"]);
                                    $email =filter($_POST["email"]);
                                    $password =filter($_POST["password"]); 
                                    
                                    $update = $con->prepare("UPDATE $tbname SET username=:username, email=:email, password=:password WHERE id=:id");
                                    $update->bindParam(":id", $id);
                                    $update->bindParam(":username", $username);
                                    $update->bindParam(":email", $email);
                                    $update->bindParam(":password", $password);
                                    $update->execute();
                                    header("Location: ".$_SERVER['PHP_SELF']);
                                }
                                $id = $v["id"];
                                if(isset($_POST["delete$id"])){
                                    
                                    $delete = $con->prepare("DELETE FROM $tbname WHERE id='$id' ");
                                    $delete->execute();
                                    header("Location: ".$_SERVER['PHP_SELF']);
                                
                                
                               /////////////////////////////
                            
                        }
                    }
                    
            
            
                }catch(Exception $e){echo "note connected".$e->getMessage();}
            
            }else{echo "emptypassword";}
         }else{echo "emptyemail";}
    }else{echo "emptyusername";}
   
   
}
}
?>
    </table>
 
</body>
</html>