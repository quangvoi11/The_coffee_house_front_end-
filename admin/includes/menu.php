<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>
  ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: azure;
  }

  li {
    float: left;
  }

  li a,
  .dropbtn {
    display: inline-block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
  }

  li a:hover,
  .dropdown:hover .dropbtn {
    background-color: red;
  }

  li.dropdown {
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
  }

  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
  }

  .dropdown-content a:hover {
    background-color: #f1f1f1;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }
</style>
</head>

<body>
  <ul>
    <?php
    include("db.php");

    $queryMenu = "SELECT * FROM tblmenu WHERE ParentMenuId = -1";
    $resultMenu = mysqli_query($conn, $queryMenu);
    while ($rowMenu = mysqli_fetch_assoc($resultMenu)) {
      $queryChild = "SELECT * FROM tblmenu WHERE ParentMenuId =" . $rowMenu['MenuID'];
      $resultChild = mysqli_query($conn, $queryChild);
      $isChild = mysqli_num_rows($resultChild) > 0;
    ?>
      <li class="dropdown">
        <a href="<?php echo $rowMenu['UrlControl'] ?>" class="dropbtn"><?php echo $rowMenu['Name'] ?></a>
        <?php if ($isChild) { ?>
          <div class="dropdown-content">
            <?php while ($rowChild = mysqli_fetch_assoc($resultChild)) { ?>
              <a href="<?php echo $rowChild['UrlControl'] ?>"> <?php echo $rowChild['Name'] ?> </a>
            <?php } ?>
          </div>
        <?php } ?>
      </li>
    <?php
    }
    ?>

    <?php if (isset($_SESSION['username'])) { ?>
      <li><a href="account.php">Account</a></li>
      <li><a href="logout.php">Logout</a></li>
    <?php } else { ?>
      <li><a href="login.php">Login</a></li>
      <li><a href="register.php">Register</a></li>
    <?php } ?>
  </ul>
</body>

</html>