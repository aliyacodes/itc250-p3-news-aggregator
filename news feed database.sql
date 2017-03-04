/*
  starter.sql - updated 4/17/2014
  
  Here are a few notes on things below that may not be self evident:
  
  INDEXES: You'll see indexes below for example:
  
  INDEX SurveyID_index(SurveyID)
  
  Any field that has highly unique data that is either searched on or used as a join should be indexed, which speeds up a  
  search on a tall table, but potentially slows down an add or delete
  
  TIMESTAMP: MySQL currently only supports one date field per table to be automatically updated with the current time.  We'll use a 
  field in a few of the tables named LastUpdated:
  
  LastUpdated TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP
  
  The other date oriented field we are interested in, DateAdded we'll do by hand on insert with the MySQL function NOW().
  
  CASCADES: In order to avoid orphaned records in deletion of a Survey, we'll want to get rid of the associated Q & A, etc. 
  We therefore want a 'cascading delete' in which the deletion of a Survey activates a 'cascade' of deletions in an 
  associated table.  Here's what the syntax looks like:  
  
  FOREIGN KEY (SurveyID) REFERENCES wn17_surveys(SurveyID) ON DELETE CASCADE
  
  The above is from the Questions table, which stores a foreign key, SurveyID in it.  This line of code tags the foreign key to 
  identify which associated records to delete.
  
  Be sure to check your cascades by deleting a survey and watch all the related table data disappear!
  
  
*/


SET foreign_key_checks = 0; #turn off constraints temporarily

#since constraints cause problems, drop tables first, working backward
DROP TABLE IF EXISTS wn17_NewsCategories;
DROP TABLE IF EXISTS wn17_NewsFeeds;
  
#all tables must be of type InnoDB to do transactions, foreign key constraints
CREATE TABLE wn17_NewsCategories(
CategoryID INT UNSIGNED NOT NULL AUTO_INCREMENT,
CategoryName VARCHAR(255) DEFAULT '',
CategoryDescription TEXT DEFAULT '',
DateAdded DATETIME,
LastUpdated TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (CategoryID)
)ENGINE=INNODB; 

#inserting categories
INSERT INTO wn17_NewsCategories VALUES (NULL,'Technology','News feeds about technology',NOW(),NOW()); 
INSERT INTO wn17_NewsCategories VALUES (NULL,'Science','News feeds about science',NOW(),NOW());
INSERT INTO wn17_NewsCategories VALUES (NULL,'World','News feeds about the broader world',NOW(),NOW()); 

#foreign key field must match size and type, hence SurveyID is INT UNSIGNED
CREATE TABLE wn17_NewsFeeds(
FeedID INT UNSIGNED NOT NULL AUTO_INCREMENT,
CategoryID INT UNSIGNED DEFAULT 0,
FeedName TEXT DEFAULT '',
FeedDescription TEXT DEFAULT '',
DateAdded DATETIME,
LastUpdated TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
QueryString TEXT DEFAULT '',
PRIMARY KEY (FeedID),
INDEX CategoryID_index(CategoryID),
FOREIGN KEY (CategoryID) REFERENCES wn17_NewsCategories(CategoryID) ON DELETE CASCADE
)ENGINE=INNODB;

#inserting feeds
INSERT INTO wn17_NewsFeeds VALUES (NULL,1,'Video Games','News about video games',NOW(),NOW(), 'video+games');
INSERT INTO wn17_NewsFeeds VALUES (NULL,1,'Hacking','News about hacking',NOW(),NOW(), 'hacking');
INSERT INTO wn17_NewsFeeds VALUES (NULL,1,'Robots','News about robots',NOW(),NOW(), 'robots');
INSERT INTO wn17_NewsFeeds VALUES (NULL,2,'Climate','News about the climate',NOW(),NOW(), 'climate');
INSERT INTO wn17_NewsFeeds VALUES (NULL,2,'Gene Editing','News about gene editing',NOW(),NOW(), 'gene+editing');
INSERT INTO wn17_NewsFeeds VALUES (NULL,2,'Vaccines','News about vaccines',NOW(),NOW(), 'vaccines');
INSERT INTO wn17_NewsFeeds VALUES (NULL,3,'Economy','News about the economy',NOW(),NOW(), 'economy');
INSERT INTO wn17_NewsFeeds VALUES (NULL,3,'Fascism','News about contemporary politics',NOW(),NOW(), 'fascism');
INSERT INTO wn17_NewsFeeds VALUES (NULL,3,'Justin Trudeau','News about Canadian Prime Minister Justin Trudeau',NOW(),NOW(), 'justin+trudeau');

/*
Add additional tables here
*/

SET foreign_key_checks = 1; #turn foreign key check back on