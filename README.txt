
src
	htmlCSS
		home.html - html for the home page
		homeStyleSheet.css - css for the home.html page
		stockSearch.html - simple page with a button that calls searchPage.js to test the javascript
		wsb.jpg - the logo
		
		scripts
			companylist.csv - csv file of all companies on the NASDAQ with their stock symbol and other info
			jquery.min.js - jquery file
			logInfo.php - database login information
			logInPage.php - page in which you can attempt to log in
			searchBarSearch.php - looks up stocks from the company list on our sql server
			stockNamesSQL.php - program that populates the table stocks with the file companylist.csv
			stockSearch.js - ajax requests specific stock data and prints it
			wsbRegister.php - allows you to create a user which gets added to the database
	SQL
		wsblog.sql - our mysql database backup