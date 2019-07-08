//this is my API key
const keyToken = "api_token=Yo0mpIdLPhffFMpfbbn5QOfCIBsq5vnH3LdlnU0rbEKHH8D5ZlHtzTpz3lWe";
//this is the home link
const home = "https://intraday.worldtradingdata.com/api/v1/intraday?symbol=";
//the stocks we want data for
var stock = "AAPL&range=1&interval=1&";	
	
var stockPricePerMin = [];



	//does the ajax request and also document.writes the amt of time it took
	$(document).ready(function(){
		var Url = home.concat(stock).concat(keyToken);
		
		$('#button').click(function(){
			var start_time = new Date().getTime();

			$.ajax({
				url: Url,
				type: "GET",
				success: function(result){
					var request_time = new Date().getTime() - start_time;
					document.write("request time: " + request_time + " ms" + '<br>');
					
					
					priceArrayBuilder(result);
					
				},
				error: function(error){
					console.log('Error ${error}')
				}
			})
			
		})
		
	})
	
	
//	document.write(getFormattedDateTime() + '<br>');
	isMarketClosed();
	
	
	
	/**
	 * returns formatted date and time
	 * @returns
	 */
	function getFormattedDateTime() {
		var date = new Date();
//		2019-06-10 15:59:00
		
		var formattedDate = date.getFullYear() + "-" + ('0' + (date.getMonth() + 1)).slice(-2) 
		+ "-" + ('0' + date.getDate()).slice(-2) + " " 
		+ ('0' + date.getHours()).slice(-2) + ":" + ('0' + date.getMinutes()).slice(-2) 
		+ ":" + ('0' + date.getSeconds()).slice(-2);
		
		return formattedDate;
	}
	
	/**
	 * checks to see if market is closed based on NYSE
	 * change this to php so that it is server side
	 * @returns
	 */
	function isMarketClosed() {
		
		var date = new Date();
		var isClosed = false;
		
		//(hours >= 13 OR hours < 6) OR (hours = 6 and minutes < 30)
		if ((parseInt(date.getHours()) >= 13 || parseInt(date.getHours()) < 6) || 
				(parseInt(date.getHours()) == 6 && parseInt(date.getMinutes()) < 30) ) {
			isClosed = true;
		} 
		
		return isClosed;
		

	}
	/**
	 * takes json ajax, and prints the open price of the stock at second intervals
	 * @param result
	 * @returns
	 */
	function priceArrayBuilder(result) {
		document.write("Stock data for " + stock + ": " + '<br>');
		for (var x in result["intraday"]) {
			stockPricePerMin.push(result["intraday"][x]["open"]);
		}
		
		stockPricePerMin.reverse();
		printStockPrice(stockPricePerMin);
	}
	
	
	
	/**
	 * prints the array of prices with the time 
	 * @param array
	 * @param time
	 * @returns
	 */
	function printStockPrice(array) {
		for (let i = 0; i < array.length; i++) {
			(function(){ document.write("$" + array[i] + '<br>'); })();
		}
	}
	


	
	
	
	