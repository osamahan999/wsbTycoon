A stock trading platform that is currently in progress of being built. It uses data scraped from Yahoo Finance, and stores all the user data on a MySQL server. 

All user data is hashed and stored securily, and no user information is stored in cookies or other vulnerable data.

I use HTML5, CSS3, JavaScript, and JQuery for the frontend. I built the pages using basic HTML and JS, as I am not a very good frontend developer. I used JQuery to communicate with the backend using AJAX, where I am using PHP and MySQL. The PHP is used to communicate with the SQL server and to run most of the logic. 

The search bar utilizes a list of stocks in my database and clever engineering to autocomplete, built fully in this project without an external library. 

This project was inspired by reddit.com/r/wallstreetbets where people gamble far too much money on far too risky 'investments'. I decided that I wanted to be a part
of these high rollers, but I did not want the risk. And so, I decided to begin working on this simulator.

I learned a lot working on this project. In the process I taught myself HTML5, CSS3, JavaScript, JQuery, PHP, and MySQL. I also taught myself a lot about REST APis and how to build an efficient database, and store data efficiently. 

I am currently not working on this project simply due to changed interests, but will most likely pick it back up some other time. 


src
	home page
		home.html - html mark up for home page
		homeStyleSheet.css - css that goes with home.html
		watchList
			watchListLoadPrices.js - ajax requests prices for watchlist stocks. also ajaxs watchlist stocks from database
			watchListLoadPrices.php - pulls watch-list data for specific users. information will be put on home page.
		searchBar
			searchBar.html - test search bar
			searchBarSearch.php - gets top 5 closest search results. will be called each time a character is added/deleted from search bar
			searchBarQuery.js - ajax requests searchBarSearch.php for array of top 5. prints these as autocomplete section.
			searchBar.css - css for searchBar.html
			BST
				BinarySearchTree.js - loads up stock data into bst, and then performs search. most likely will not be used. SQL simply better.
	
	login and registration
		logInPage.php - a page where you put your credentials and it checks if you're in the system. if so, logged in.
		wsbRegister.php - a page where you can register an account into our database	
	
	
	SQL
		wsblog.sql - MYSQLDUMP file for our database
	
	
	stock api ajax
		stockSearch.html - test html page with a button that calls stockSearch.js
		stockSearch.js - ajax requests for stock data
		
	
	stockPurchase
		stockPage.html - just a form to test purchasing stocks with
		stockPurchase.js - takes form data and purchases the stock for the user
	
	util 
		access
			logInfo.php - database access info
		
		
		csv files
			companylist.csv - has most stocks with data for each one in it.
		
		
		external libraries 
			jquery.min.js - jQuery
		
		
		helper scripts
			createUsersTable.php - creates the users table when called
			getSortedArray.php - outputs the alphabetically sorted 2D array of stock names and symbols as a string.
			stockNameSQL.php - populates stocks table with companylist.csv 's data
		
		
		images
			wsb.jpg - wallstreetbets icon

README.txt			
