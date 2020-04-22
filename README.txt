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