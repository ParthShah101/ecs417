<!DOCTYPE = html>
<html>
<head lang="en">
  <meta charset="utf-8">
  <title>Parth Shah</title>
  <link rel="stylesheet" href="reset.css" type="text/css"/>
  <link rel="stylesheet" href="comment.css">
</head>
<body>
  <div class="post">
    <h1>Post</h1>
    <br>
    <?php
      session_start();
      $dbhost = getenv("MYSQL_SERVICE_HOST");
      $dbport = getenv("MYSQL_SERVICE_PORT");
      $dbuser = getenv("DATABASE_USER");
      $dbpwd = getenv("DATABASE_PASSWORD");
      $dbname = getenv("DATABASE_NAME");
      $db = new mysqli($dbhost, $dbuser, $dbpwd, $dbname) or die("Cant Connect to database");
      $id = $_POST['id'];
      $query = mysqli_query($db,"SELECT * FROM post WHERE id = '$id'") or die("Database error");
      $row = mysqli_fetch_assoc($query);
      $title = $row['post_title'];
      $text = $row['post_text'];
      $date = $row['post_date'];
      $commentquery = mysqli_query($db,"SELECT * FROM comment WHERE post_ID = '$id'") or die("Database error");
      if($_SESSION['super'] == true)
      {
        echo "<br><h3>Post ID: $id <br><br> Title: $title<h3><br><p>$text</p><br><p>Time: $date</p><br><hr>";
        if(mysqli_num_rows($commentquery) > 0)
        {
          while($commentrow = mysqli_fetch_assoc($commentquery))
          {
            $comment_id = $commentrow['ID'];
            $comment_text = $commentrow['comment_text'];
            $user_id = $commentrow['user_ID'];
            echo "<br><h1>User: $user_id</h1><br><h1>Comment: </h1><br><p>$comment_text</p><form method='POST' action='commentdelete.php'><input type='hidden' name='id' value='$comment_id'><br><input type='submit' value='Delete'></form><br><hr>";
          }
        }
        else
        {
          echo '<br>No Comments to Display<br>';
        }
        echo "<form method='POST' action='commentprocess.php'><input type='hidden' name='id' value='$id'><label>Enter Comment</label><br><textarea name='text' rows='10' cols='50' required='true'></textarea><br><input type='submit'></form>";
        echo'<br><br><a href="blog.php" class="button">Back<a>';
      }
      elseif($_SESSION['logged_in'] == true)
      {
        echo "<br><h3>Title: $title<h3><br><p>$text</p><br><p>Time: $date</p><br><hr>";
        if(mysqli_num_rows($commentquery) > 0)
        {
          while($commentrow = mysqli_fetch_assoc($commentquery))
          {
            $comment_id = $commentrow['ID'];
            $comment_text = $commentrow['comment_text'];
            $user_id = $commentrow['user_ID'];
            echo "<br><h1>User: $user_id</h1><br><h1>Comment: </h1><br><p>$comment_text</p><br><hr>";
          }
        }
        else
        {
          echo '<br>No Comments to Display<br>';
        }
        echo "<form method='POST' action='commentprocess.php'><input type='hidden' name='id' value='$id'><label>Enter Comment</label><br><textarea name='text' rows='3' cols='50' required='true'></textarea><br><input type='submit'></form>";
        echo'<br><br><a href="blog.php" class="button">Back<a>';
      }
      else
      {
        echo "<br><h3>Title: $title<h3><br><p>$text</p><br><p>Time: $date</p><br><hr>";
        while($commentrow = mysqli_fetch_assoc($commentquery))
        {
          $comment_id = $commentrow['ID'];
          $comment_text = $commentrow['comment_text'];
          $user_id = $commentrow['user_ID'];
          echo "<br><h1>User: $user_id</h1><br><h1>Comment: </h1><br><p>$comment_text</p><br><hr>";
        }
        echo 'You must log in or register to add a comment<br></form>';
        echo'<br><br><a href="blog.php" class="button">Back<a>';
      }
    ?>
  </div>
</body>
</html>
