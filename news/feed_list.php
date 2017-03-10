<?php
/**
 * demo_idb.php is both a test page for your IDB shared mysqli connection, and a starting point for 
 * building DB applications using IDB connections
 *
 * @package nmCommon
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 2.09 2011/05/09
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see config_inc.php  
 * @see header_inc.php
 * @see footer_inc.php 
 * @todo none
 */
# '../' works for a sub-folder.  use './' for the root
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

# check variable of item passed in - if invalid data, forcibly redirect back to demo_list.php page
if(isset($_GET['catid']) && (int)$_GET['catid'] > 0){#proper data must be on querystring
	 $catID = (int)$_GET['catid']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "news/categories.php");
}

$config->titleTag = smartTitle(); #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription; 
/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

# SQL statement - PREFIX is optional way to distinguish your app
//$sql = "SELECT * FROM wn17_NewsCategories";
 
    
//# check variable of item passed in - if invalid data, forcibly redirect back to demo_list.php page
//if(isset($_GET['catid']) && (int)$_GET['catid'] > 0){#proper data must be on querystring
//	 $catID = (int)$_GET['catid']; #Convert to integer, will equate to zero if fails
//}else{
//	myRedirect(VIRTUAL_PATH . "news/categories.php");
//}

$sql = 
    "select f.CategoryID, f.FeedID, f.FeedName, f.FeedDescription, f. QueryString 
    from " . PREFIX . "NewsFeeds f 
    where f.CategoryID=" . $catID . " order by f.FeedID";

//END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to header_inc.php
?>
<h3 align="center"><?php echo $config->titleTag; ?></h3>
<p>This page  is both a test page for your IDB shared mysqli connection, and a starting point for 
 * building DB applications using IDB connections</p>
<p>creates a singleton (shared) mysqli connection via a class named IDB</p>
<?php
#IDB::conn() creates a shareable database connection via a singleton class
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

echo '<div align="center"><h4>SQL STATEMENT: <font color="red">' . $sql . '</font></h4></div>';
if(mysqli_num_rows($result) > 0)
{#there are records - present data
	while($row = mysqli_fetch_assoc($result))
	{# pull data from associative array
	   echo '<p>';
	   echo 'Title: <b>' . $row['FeedName'] . '</b><br />';
	   echo 'Description: <b>' . $row['FeedDescription'] . '</b><br />';
       echo '<a href="feed.php?catid=' . $catID . '&feedid=' . $row['FeedID'] . '">' . $row['FeedName'] . '</a>';
	   echo '</p>';
	}
}else{#no records
	echo '<div align="center">Sorry, there are no records that match this query</div>';
}
@mysqli_free_result($result);
get_footer(); #defaults to footer_inc.php
?>
