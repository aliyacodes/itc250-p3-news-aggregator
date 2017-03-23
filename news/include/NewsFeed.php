<?php

/**
*
* A class to handle RSS news feeds with Session caching 
*
* @author James Overholzer, Joseph Wanderer
**/


class NewsFeed 
{
    public $feedID;
    public $categoryID;
    public $categoryName;
    public $categoryDescription;
    public $feedName;
    public $feedDescription;
    public $queryString;
    public $feed;
    

    
    /*
        Constructs a NewsFeed object that mirrors the NewsFeeds db table
        @param $feedID: The pr. 
        @param $categoryID: a short description of the menu item. 
        @param $feedName: the price per single unit of the item. 
        @param $feedDescription: an array of quantity options for the item. Ex: [1,2,3,4,5]
        @param $queryString: the price per single unit of the item. 
    */
    //public function __construct($feedID, $categoryID, $feedName, $feedDescription, $queryString)
    public function __construct($feedDetails)
    {
        //$feedDetails = $result;
        
        $this->feedID = $feedDetails['FeedID'];
        $this->categoryID = $feedDetails['CategoryID'];
        $this->categoryName = $feedDetails['CategoryName'];
        $this->categoryID = $feedDetails['CategoryDescription'];
        $this->feedName = $feedDetails['FeedName'];
        $this->feedDescription = $feedDetails['FeedDescription'];
        $this->queryString = $feedDetails['QueryString'];
        
//        $this->feedID = $feedID;
//        $this->categoryID = $categoryID;
//        $this->feedName = $feedName;
//        $this->feedDescription = $feedDescription;
//        $this->queryString = $queryString;
        
//        if(isset($_SESSION['Feeds']) && isset($_SESSION['Feeds'][$this->feedID]))
//        { 
//            //do nothing, feed already exists
//        }else{//create new
            
            $feed = '';
            $request = 'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=' . $this->queryString . '&output=rss';
            $response = file_get_contents($request);
            $xml = simplexml_load_string($response);
        
        $feed .= 
            '
        
        
            ';

            $feed .= '<p>';
            $feed .= 'Feed Name: <b>' . $this->feedName . '</b><br />';
            $feed .= 'Description: <b>' . $this->feedDescription . '</b><br />';
        
            $feed .= '</p>';

         //$feed .= '<h2>' . $feedDetails["CategoryName"] . ' - ' . $xml->channel->title . '</h2>';
            foreach($xml->channel->item as $story)
            {
                $feed .= '<p>';
                $feed .= 'Article Title: ' . '<a href="' . $story->link . '">' . $story->title . '</a><br />';
                $feed .= '</p>';
                $feed .= '<p>' . $story->description . '</p><br />';
            }
            
            $this->feed = $feed;
            
            //$_SESSION['Feeds'][$this->feedID] = $this;
            
        }
        
    
    public function showFeed()
    {     
        echo $this->feed;
    }
        
    
    public static function clearFeed($feedID)
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        
        if(isset($_SESSION['Feeds'][$feedID]))
           {
               $_SESSION['Feeds'][$feedID] = ''; //clear data
            
               unset($_SESSION['Feeds'][$feedID]);//wipe memory
           
           }
    }
    
    
    public static function clearAllFeeds()
    {
        if(!isset($_SESSION)){session_start();}
        
        if(isset($_SESSION['Feeds']))
        {
            $_SESSION['Feeds'] = array(); //clear data
            
            unset($_SESSION['Feeds']);//wipe memory
        }
        
    }
    
}
