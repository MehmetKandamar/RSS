<!DOCTYPE html>
<html lang="en">
<head>
    <title>RSS FEED</title>
    <link rel="stylesheet" href="style.css">
</head>
 <body>
  <?php

     function rssRead($url){

       $take = simplexml_load_file($url);

       echo "<ul>";

       foreach ($take->channel->item as $entry){?>
       <div class="relative">
           <?php
           $db= mysqli_connect("localhost", "root", "", "feeds");
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

  <h2 id="tit" >Ekonomi Haberleri</h2>
  <?php

  echo rssRead("http://www.trt.net.tr/rss/ekonomi.rss") ;
  echo "<br>";

  ?>

  <h2 id="tit" >Dünyadan Haberler</h2>

  <?php

  echo rssRead( "http://www.trt.net.tr/rss/dunya.rss");
  echo "<br>";
 ?>
  <h2 id="tit" >Spor Haberleri</h2>

  <?php

  echo rssRead( "http://www.trt.net.tr/rss/spor.rss");
  echo "<br>";
  ?>


 </body>

</html>