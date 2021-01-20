<?php

// database bağlantısı
$db = mysqli_connect("localhost", "root", "", "feeds");

if (isset($_POST['submit'])){
    $newUrl = $db->real_escape_string($_POST['newUrl']);
    $sql = "INSERT INTO urls (url) VALUE ('$newUrl')";
    mysqli_query( $db, $sql);
}

?>

<!DOCTYPE html>
<html lang="en">
<title>RSS FEED</title>
<link rel="stylesheet" href="style.css">
 <body>
  <?php

     function rssRead($url){
         $db= mysqli_connect("localhost", "root", "", "feeds");
       $take = simplexml_load_file($url);
         $title=  $take->channel->title
?>
         <h2 id="tit" ><?php echo "$title" ?></h2>

         <?php
       echo "<ul>";

       foreach ($take->channel->item as $entry){?>
       <div class="relative">
           <?php
           $date = $take->channel->lastBuildDate;
                echo "<h4><li><a href ='$entry->link' title='entry->title' target='_blank'>". $entry->title."</a></li></h4>";
                echo $entry->description."<br><br><br><br><br><br><br>" ;
                ?> <div class="absolute"> <?php
                echo "<img src=\"" . $entry->enclosure['url'][0] . "\" width=200 height= 155>";
               $link = $entry->link;
               $head= $entry->title;
               $description = $entry->description;
               $sql = "INSERT INTO rssfeeds (heads, descriptions, dates, links) VALUES ('$head', '$description', '$date', '$link')";
               mysqli_query( $db, $sql);
               ?> </div> <?php
            }
            ?>
       </div>
       <?php
         echo "</ul>";

              }
        ?>

  <div id="date1">
      <?php

  $mydate=getdate(date("U"));
  echo "$mydate[weekday], $mydate[month] $mydate[mday], $mydate[year]";

   ?>
  </div>

  <?php
  $sqll = 'SELECT * FROM urls';
  $getData = mysqli_query($db,$sqll);
  foreach ($getData as $sqlurl)
  {
      rssRead($sqlurl['url']);
      echo "<br>";
  }
  ?>

  <form method="post" action=" " class="input_form">
      <label>
          <input type="text" name="newUrl" class="newUrl">
      </label>
      <button type="submit" name="submit" id="add_btn" class="add_btn">Add Url</button>
  </form>


 </body>

</html>