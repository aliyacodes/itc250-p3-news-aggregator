<?
//feed.php
//our simplest example of consuming an RSS feed


require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
require 'include/NewsFeed.php'; #NewsFeed class
$config->titleTag = smartTitle(); #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription; 

if(isset($_GET['feedid']) && (int)$_GET['feedid'] > 0){#proper data must be on querystring
	 $feedID = (int)$_GET['feedid']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "news/categories.php");
}

# Read the value of 'action' whether it is passed via $_POST or $_GET with $_REQUEST
if(isset($_REQUEST['act'])){$myAction = (trim($_REQUEST['act']));}else{$myAction = "";}
{

    switch ($myAction) 
{//check 'act' for type of process
	case "clearFeed": # 2)Display user's name!
	 	NewsFeed::clearFeed($feedID);
	 	break;
    case "clearAllFeeds": # 2)Display user's name!
	 	NewsFeed::clearAllFeeds();
	 	break;
	default: 
            break;
}
    
    //$feedID = (int)$_GET['feedid']; #Convert to integer, will equate to zero if fails
}

if (isset($_SESSION['Feeds'][$feedID]['Retrieved']) && (time() - $_SESSION['Feeds'][$feedID]['Retrieved'] > 1800)) {
    // last request was more than 30 minutes ago
    NewsFeed::clearFeed($feedID); 
}

//else{
//	myRedirect(VIRTUAL_PATH . "news/categories.php");
//}


       if(isset($_SESSION['Feeds']) && isset($_SESSION['Feeds'][$feedID]['Feed']) && isset($_SESSION['Feeds'][$feedID]['Retrieved']))
        { 
           get_header(); #defaults to header_inc.php
           echo 
               '
               <p>Feed Retrieved: ' . date("Y-m-d h:i:sa", $_SESSION['Feeds'][$feedID]['Retrieved']) . '</p>
               <form action="feed.php?feedid=' . $feedID . '" method="post">
               <input type="hidden" name="act" value="clearFeed">
               <input type="submit" value="Clear Feed">
               </form>
               
               <form action="feed.php?feedid=' . $feedID . '" method="post">
               <input type="hidden" name="act" value="clearAllFeeds">
               <input type="submit" value="Clear All Feeds">
               </form>
               </br>
               ';
           
           echo $_SESSION['Feeds'][$feedID]['Feed'];
           
           get_footer(); #defaults to header_inc.php
           
        }else{
           $sql = 
               "select c.CategoryID, c.CategoryName, c.CategoryDescription, f.FeedID, f.FeedName, f.FeedDescription, f.QueryString 
               from " . PREFIX . "NewsCategories c, " . PREFIX . "NewsFeeds f 
               where c.CategoryID=f.CategoryID and f.FeedID=" . $feedID . " order by f.FeedID";

           #IDB::conn() creates a shareable database connection via a singleton class
           $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));



           if(mysqli_num_rows($result) > 0)
           {#there are records - present data
    
    

               $feedDetails = mysqli_fetch_assoc($result);

               $myFeed = new NewsFeed($feedDetails);
               
               //$testFeed = new NewsFeed($feedDetails['FeedID'], $feedDetails['CategoryID'], $feedDetails['FeedName'], $feedDetails['FeedDescription'], $feedDetails['QueryString']);
               //echo '<h1>echo</h1>'
    
               //var_dump($testFeed);
    
               @mysqli_free_result($result);
    
               //dumpDie($feedDetails);
               //dumpDie($testFeed);
    
    //dumpDie(mysqli_fetch_assoc($feedDetails);
    
    //$feedName = $feedDetails['FeedName'];
    

    
//prevents warning notices if session is already started
               
               if(!isset($_SESSION)){session_start();}
               
               $_SESSION['Feeds'][$feedID]['Feed'] = $myFeed->feed;
               $_SESSION['Feeds'][$feedID]['Retrieved'] = time();

               get_header(); #defaults to header_inc.php
               
               echo 
               '
               <p>Feed Retrieved: ' . date("Y-m-d h:i:sa", $_SESSION['Feeds'][$feedID]['Retrieved']) . '</p>
               <form action="feed.php?feedid=' . $feedID . '" method="post">
               <input type="hidden" name="act" value="clearFeed">
               <input type="submit" value="Clear Feed">
               </form>
               
               <form action="feed.php?feedid=' . $feedID . '" method="post">
               <input type="hidden" name="act" value="clearAllFeeds">
               <input type="submit" value="Clear All Feeds">
               </form>
               </br>
               ';
               
               $myFeed->showFeed();
               
               get_footer(); #defaults to footer_inc.php
    
//if (!isset($_SESSION['CREATED'])) {
//    $_SESSION['CREATED'] = time();
//} else if (time() - $_SESSION['CREATED'] > 30) {
//    // session started more than 30 minutes ago
//    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
//    $_SESSION['CREATED'] = time();  // update creation time
           
           }else{#no records
               
               echo '<div align="center">Sorry, there are no records that match this query</div>';
           }

       }

//dumpDie($myFeed);
    

/*
    if(isset($_SESSION['Feeds']) && isset($_SESSION['Feeds'][$feedName]))
{//if session var exists, echo it
        //echo 'session';
        //dumpDie($testFeed);
//        get_header(); #defaults to header_inc.php
//        echo $_SESSION['Feeds'][$feedName];	
//        get_footer(); #defaults to footer_inc.php        

}else{//create new
        
        //echo 'no session';
        //dumpDie($testFeed);
        
        
        
        $feed = '';
        $request = 'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=' . $feedDetails["QueryString"] . '&output=rss';
        $response = file_get_contents($request);
        $xml = simplexml_load_string($response);
            
       $feed .= '<p>';
	   $feed .= 'Feed Name: <b>' . $feedDetails['FeedName'] . '</b><br />';
	   $feed .= 'Description: <b>' . $feedDetails['FeedDescription'] . '</b><br />';
	   $feed .= '</p>';
        
 //     $feed .= '<h2>' . $feedDetails["CategoryName"] . ' - ' . $xml->channel->title . '</h2>';
      foreach($xml->channel->item as $story)
      {
          $feed .= '<p>';
          $feed .= 'Article Title: ' . '<a href="' . $story->link . '">' . $story->title . '</a><br />';
          $feed .= '</p>';
          $feed .= '<p>' . $story->description . '</p><br />';
          
          
//        $feed .= '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
//        $feed .= '<p>' . $story->description . '</p><br /><br />';
      }
        $_SESSION['Feeds'][$feedName] = $feed;
    
    
get_header(); #defaults to header_inc.php
    
 //          echo 'feed not found';
        //echo 'end';
        //dumpDie($testFeed);

    echo $_SESSION['Feeds'][$feedName];
           
get_footer(); #defaults to footer_inc.php
    
    

        
        
        
}
*/




    
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
    
//}


