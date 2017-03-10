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

if(isset($_GET['feedid']) && (int)$_GET['feedid'] > 0){#proper data must be on querystring
	 $feedID = (int)$_GET['feedid']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "news/categories.php");
}

$config->titleTag = smartTitle(); #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription; 

$sql = 
    "select c.CategoryID, c.CategoryName, c.CategoryDescription, f.FeedID, f.FeedName, f.FeedDescription, f.QueryString 
    from " . PREFIX . "NewsCategories c, " . PREFIX . "NewsFeeds f 
    where c.CategoryID=f.CategoryID and f.FeedID=" . $feedID . " order by f.FeedID";

#IDB::conn() creates a shareable database connection via a singleton class
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));



if(mysqli_num_rows($result) > 0)
{#there are records - present data
    
    
    $feedDetails = mysqli_fetch_assoc($result);
    @mysqli_free_result($result);
    
    //dumpDie(mysqli_fetch_assoc($feedDetails);
    
    $feedName = $feedDetails['FeedName'];
    

    
//prevents warning notices if session is already started
if(!isset($_SESSION)){session_start();}
    
    
//if (!isset($_SESSION['CREATED'])) {
//    $_SESSION['CREATED'] = time();
//} else if (time() - $_SESSION['CREATED'] > 30) {
//    // session started more than 30 minutes ago
//    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
//    $_SESSION['CREATED'] = time();  // update creation time
}
    
    if(isset($_SESSION['Feeds']) && isset($_SESSION['Feeds'][$feedName]))
{//if session var exists, echo it
        
        //dumpDie($_SESSION['Feeds']);
        
        
get_header(); #defaults to header_inc.php
//        echo 'session was found with the proper feed';
	echo $_SESSION['Feeds'][$feedName];	
get_footer(); #defaults to footer_inc.php        

}
    
//if(isset($_SESSION['Feeds']))
//{//if session var exists, add to existing
//	$_SESSION['Feeds'][] = new BallPlayer($_POST['Name'],$_POST['Team'],$_POST['Homers']);	
//}
       else{//create new
    
    //$_SESSION['Feeds'] = array();
           
    $feed = '';
    
    

        
      $request = 'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=' . $feedDetails["QueryString"] . '&output=rss';
      $response = file_get_contents($request);
      $xml = simplexml_load_string($response);
            
        
      $feed .= '<h2>' . $feedDetails["CategoryName"] . ' - ' . $xml->channel->title . '</h2>';
      foreach($xml->channel->item as $story)
      {
        $feed .= '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
        $feed .= '<p>' . $story->description . '</p><br /><br />';
      }
        $_SESSION['Feeds'][$feedName] = $feed;
    
    
get_header(); #defaults to header_inc.php
    
 //          echo 'feed not found';

    echo $_SESSION['Feeds'][$feedName];
           
get_footer(); #defaults to footer_inc.php
    
    
    
}

    

    
//    while($row = mysqli_fetch_assoc($result))
//	{# pull data from associative array
//        
//      $request = 'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=' . $row["QueryString"] . '&output=rss';
//      $response = file_get_contents($request);
//      $xml = simplexml_load_string($response);
//        
//      print '<h2>' . $row["CategoryName"] . ' - ' . $xml->channel->title . '</h2>';
//      foreach($xml->channel->item as $story)
//      {
//        echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
//        echo '<p>' . $story->description . '</p><br /><br />';
//      }
//        
//    }
    
}

?>