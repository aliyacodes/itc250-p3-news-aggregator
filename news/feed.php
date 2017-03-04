<?
//feed.php
//our simplest example of consuming an RSS feed
/*
  $request = "http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=star+wars&output=rss";
  $response = file_get_contents($request);
  $xml = simplexml_load_string($response);
  print '<h1>' . $xml->channel->title . '</h1>';
  foreach($xml->channel->item as $story)
  {
    echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
    echo '<p>' . $story->description . '</p><br /><br />';
  }
*/

require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

$config->titleTag = smartTitle(); #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription; 

$sql = 
    "select c.CategoryID, c.CategoryName, c.CategoryDescription, f.FeedID, f.FeedName, f.FeedDescription, f. QueryString 
    from " . PREFIX . "NewsCategories c, " . PREFIX . "NewsFeeds f 
    where c.CategoryID=f.CategoryID order by f.FeedID";

#IDB::conn() creates a shareable database connection via a singleton class
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#there are records - present data
    
    while($row = mysqli_fetch_assoc($result))
	{# pull data from associative array
        
      $request = 'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=' . $row["QueryString"] . '&output=rss';
      $response = file_get_contents($request);
      $xml = simplexml_load_string($response);
      print '<h2>' . $row["CategoryName"] . ' - ' . $xml->channel->title . '</h2>';
      foreach($xml->channel->item as $story)
      {
        echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
        echo '<p>' . $story->description . '</p><br /><br />';
      }
        
    }
    
}

?>