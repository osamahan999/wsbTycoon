//this is my API key
const keyToken = "api_token=Yo0mpIdLPhffFMpfbbn5QOfCIBsq5vnH3LdlnU0rbEKHH8D5ZlHtzTpz3lWe";
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
	console.log("this got called!");
	
	console.log(username);
	
	
	$.ajax({
		url: 'http://localhost/wsb/src/home%20page/watchList/watchListLoadPrices.php',
		type: 'get',
		dataType: 'json',
		data: {input : username},
		
		success: function(result){
			arr = result.watchList;
			setArray(arr);
			
			getPrices(arr);
			printArray(stocks);
			
		},
			
			
		error: function(error) {
			console.log("watchList ajax failed.");
		}
	});
}

function getPrices(watchList) {
	for (var i = 0; i < watchList.length; i++) {
		var Url = "https://intraday.worldtradingdata.com/api/v1/intraday?symbol=" + watchList[i] + "&range=1&interval=1&" + keyToken;			

		if (watchList[i] != null) {
			$.ajax({
				url: Url,
				type: "GET",
				async: false,
				success: function(result){
					
					populateArray(result);
				},
				error: function(error){
					console.log('Error ${error}')
				}
			})
		}
	}
}

function populateArray(result) {
	
	var counter = 0;
	var newArray = new Array();
	
	newArray.push(result["symbol"]);
	
	for (var x in result["intraday"]) {
		if (counter > 30) break;		
		newArray.push(result["intraday"][x]["open"]);
		counter++;
	}
	
	stocks.push(newArray);
	setStocks(stocks);
}

function printArray(stocks) {
	console.log("print array got called");
	
	for (var i = 0; i < stocks.length; i++) {
		console.log(i + ' ' + stocks[i][0]);
	}
	
	
}




