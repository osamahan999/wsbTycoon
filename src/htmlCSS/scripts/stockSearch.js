
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
					
//					stock_print(result["data"]);
				},
				error: function(error){
					console.log('Error ${error}')
				}
			})
			
		})
		
	})
	
	
	/**
	 * takes json ajax, and prints the open price of the stock at each minute
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
	
	
	
	
	function printStockPrice(array) {
		for (var i = 0; i < array.length; i++) {
			document.write("$" + array[i] + '<br>');
		}
	}
	
	
	// prints the stock symbol and name, the price and volume for all stocks called. 
	function stock_print(result) {
		for (i = 0; i < result.length; i++) {
			document.write(result[i]["symbol"] + ":" + result[i]["name"] + " Price: " + 
					result[i]["price"] + " Volume: " + result[i]["volume"] + '<br>');
		}
		
	}
	
	
	
	
	
	