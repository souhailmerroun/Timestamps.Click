<?php

require "vendor/autoload.php";

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";  
$pageUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];  

/*** 
 * This snippet is needed only in dev to load the .env locally.
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();
 * 
*/

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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="album.css" />
  
  <!-- Primary Meta Tags -->
  <title>Timestamps.Click - I'm the timestamps guy on Youtube</title>
  <meta name="title" content="Timestamps.Click - I'm the timestamps guy on Youtube">
  <meta name="description" content="I'm the timestamps guy on Youtube. Wanna download ya favorite parts of the video? I can help you, check me out!">

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://timestampsclick.herokuapp.com/">
  <meta property="og:title" content="Timestamps.Click - I'm the timestamps guy on Youtube">
  <meta property="og:description" content="I'm the timestamps guy on Youtube. Wanna download ya favorite parts of the video? I can help you, check me out!">
  <meta property="og:image" content="<?= $pageUrl; ?>opengraph.png">

  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="https://timestampsclick.herokuapp.com/">
  <meta property="twitter:title" content="Timestamps.Click - I'm the timestamps guy on Youtube">
  <meta property="twitter:description" content="I'm the timestamps guy on Youtube. Wanna download ya favorite parts of the video? I can help you, check me out!">
  <meta property="twitter:image" content="<?= $pageUrl; ?>opengraph.png">

  <link rel="icon" href="logo.png">
</head>
<body>
  <?php include('header.php') ?>

  <main role="main">
    <section class="jumbotron text-center">
      <div class="container">
        <h1>Timestamps.Click</h1>
        <p class="lead text-muted">I'm the timestamps guy on Youtube. Wanna download ya favorite parts of the video? I can help you, check me out!.</p>
        <p>
          <a href="#" disabled="disabled" target="_blank" class="disabled btn btn-primary my-2">How does it work (coming soon)</a>
          <a href="https://linkedin.com/in/souhailmerroun" target="_blank" class="btn btn-secondary my-2">Who built this</a>
        </p>
      </div>
    </section>

    <div class="container">
      <div class="row">
        <div class="col">
          <div class="alert alert-warning" role="alert">
            The generator is a work in progress, it can still act out weird. Please <a href="mailto:souhail.merroun1996@gmail.com" target="_blank">email</a> or <a href="https://twitter.com/souhailmerroun" target="_blank">tweet me</a> with a screenshot if you feel like something ain't right. 
          </div>
          <hr/>
          <div class="alert alert-danger" role="alert">
            Please avoid  using the symbols <code>'</code> and <code>&</code> as they cause broken scripts.  
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                  <label for="title">Title</label>
                  <input id="title"  name="video" placeholder="Example: Free Will vs Determinism - Does Free Will Exist" class="form-control" />
                </div>
                <div class="form-group">  
                  <label for="timestamps">Timestamps</label>
                  <textarea id="timestamps" name="timestamps" placeholder="4:33 7:30 No Self Control
9:20 11:38 Self Observation
11:42 12:48 Assumption 
13:03 15:32 Self Illusion
15:35 18:33 Thoughts Source
18:34 20:03 Behaviors Source
21:23 22:55 Random
..." class="form-control" rows="10"></textarea>
                </div>
                <input class="btn btn-primary" name="submit" type="submit" value="Gimme da script!"/>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <p style="white-space: nowrap; overflow-x: scroll;">
                Your ready to run script: 
                <br/> 
                <?php
                if($results) {
                  ?> 
                  <?php
                  foreach($results as $result) {
                    ?>
                      <code><?= $result ?></code><br/>
                    <?php
                  }
                  ?>
                  <br/>  
                  <?php
                }
                else {
                  ?>
                  <small>This is just an example</small> <br/>
                  <code>ffmpeg -ss 4:33 -to 7:30 -i 'Free Will vs Determinism - Does Free Will Exist.mp4' 'No Self Control .mp4'; <br/>
                  ffmpeg -ss 9:20 -to 11:38 -i 'Free Will vs Determinism - Does Free Will Exist.mp4' 'Self Observation .mp4'; <br/>
                  ffmpeg -ss 11:42 -to 12:48 -i 'Free Will vs Determinism - Does Free Will Exist.mp4' 'Assumption .mp4'; <br/>
                  ffmpeg -ss 13:03 -to 15:32 -i 'Free Will vs Determinism - Does Free Will Exist.mp4' 'Self Illusion .mp4'; <br/>
                  ffmpeg -ss 15:35 -to 18:33 -i 'Free Will vs Determinism - Does Free Will Exist.mp4' 'Thoughts Source .mp4'; <br/>
                  ffmpeg -ss 18:34 -to 20:03 -i 'Free Will vs Determinism - Does Free Will Exist.mp4' 'Behaviors Source .mp4'; <br/>
                  ffmpeg -ss 21:23 -to 22:55 -i 'Free Will vs Determinism - Does Free Will Exist.mp4' 'Random.mp4';</code>
                  <?php

                }
                ?>
              </p> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-156697578-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '<?= getenv('GOOGLE_ANALYTICS'); ?>');
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>