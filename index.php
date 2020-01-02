<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  <?php
  if(isset($_POST['submit']))
  {
    $timestamps = $_POST['timestamps'];
    $video      = $_POST['video'];
    $lines      = explode("\n", $timestamps);
    $results    = [];
    
    foreach($lines as $line) {
      $regex = '/([^\s]+) ([^\s]+) (.*)/';
      preg_match($regex, $line, $parts, PREG_OFFSET_CAPTURE, 0);
      
      $start = $parts[1][0];
      $end   = $parts[2][0];
      $title = $parts[3][0];
      
      $temporary = "ffmpeg -ss $start -to $end -i '$video.mp4' '$title.mp4';";
      array_push($results, $temporary);
    }
  }
  ?>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input name="video" value="Fighting Boredom and Anxiety at Work | At the Whiteboard" />
    <textarea name="timestamps"></textarea>
    <input name="submit" type="submit">
  </form>
  
  <?php
    if($results) {
      ?> 
      <p>
      <?php
      foreach($results as $result) {
        ?>
          <code><?= $result ?></code><br/>
        <?php
      }
      ?>
      </p>  
      <?php
    }
  ?>
  
  <!-- 
    - Perfectionnism:
    - textarea single or double brackets?
  -->
  
</body>
</html>