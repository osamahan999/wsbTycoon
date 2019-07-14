//this is my API key
const keyToken1 = "api_token=Yo0mpIdLPhffFMpfbbn5QOfCIBsq5vnH3LdlnU0rbEKHH8D5ZlHtzTpz3lWe";
const keyToken2 = "api_token=2DnezxV4AGG6QUJvMhxs1B0UmTtdJOQ1Nzld9uGZCraYHpOUO7baA7AmB0av";
//this is the home link
const home = "https://intraday.worldtradingdata.com/api/v1/intraday?symbol=";

var arr = new Array();
var stocks = new Array();


//sets global array
function setArray(arr) {
	this.arr = arr;
}

function setStocks(stocks) {
	this.stocks = stocks;
}

//takes in username, queries sql for watch-list preferences, ajax api for prices
function getWatchList(username) {	
	//username of person we're loading the watchlist for
	console.log(username);
	
	/**
	 * a get-ajax request which takes in a username and returns an array of strings. 
	 */
	$.ajax({
		url: 'http://localhost/wsb/src/home%20page/watchList/watchListLoadPrices.php',
		type: 'get',
		dataType: 'json',
		data: {input : username},
		
		success: function(result){
			arr = result.watchList;
			//sets array to be global
			setArray(arr);
			
			//calls get prices which ideally should populate the stocks array with last 30 minutes of stock data for each watchlist stock
			getPrices(arr);
			// prints the array of stocks
			printArray(stocks);
			
		},
			
			
		error: function(error) {
			console.log("watchList ajax failed.");
		}
	});
}

//takes in an array of strings. 
function getPrices(watchList) {
	//called for all stocks in watch list
	for (var i = 0; i < watchList.length; i++) {
		//builds url
		var Url = "https://intraday.worldtradingdata.com/api/v1/intraday?symbol=" + watchList[i] + "&range=1&interval=1&" + keyToken1;			
		
		//if stock is not null, continue
		if (watchList[i] != null) {
			$.ajax({
				url: Url,
				type: "GET",
				async: false,
				success: function(result){
					//populates our stock array with data for said non-null stock
					populateArray(result);
				},
				error: function(error){
					console.log('Error ${error}')
				}
			})
		}
	}
}

//takes in array of stock data. creates an array of 30 mins of that data and stores it in stocks 
function populateArray(result) {
	
	var counter = 0;
	var newArray = new Array();
	
	
	for (var x in result["intraday"]) {
		//only 30 mins worth of data
		if (counter > 30) break;
		
		newArray.push(result["intraday"][x]["open"]);
		counter++;
	}
	
	var stockName = result["symbol"];
	stocks[stockName] = newArray;
	
	setStocks(stocks);
}

function printArray(stocks) {
	
	for (var x in stocks) {
		console.log(x);
	}
	
	
}




