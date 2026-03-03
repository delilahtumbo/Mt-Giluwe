<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Strict//EN" "http: www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns ="http://www.w3.org/1999/xhtml">
<body>
    <?php 
    include "form_db.php";
  /*
    echo $_POST["usernsame"];
    ecoh "<br>";
    echo $_POST["password"];
   */ 
  $username =$_POST['username'];
  $password =md5($_POST['password']);

  $sql ="INSERT INTO forms.login_form (username,pw) VALUES(NULL, '$username', '$password')";

  if (mysqli_query($conn, $sql))
  {
    echo "New record created successfully";
    header('Refresh:5; URL=http:localhost/formssolution/login.php');
  }
  else
  {
    echo "Error: " .$sql . "<br>" . mysqli_error($conn);
  }

  mysqli_close($conn);
    ?>
    
</body>