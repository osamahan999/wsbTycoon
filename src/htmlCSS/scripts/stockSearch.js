
//this is my API key
const keyToken = "api_token=Yo0mpIdLPhffFMpfbbn5QOfCIBsq5vnH3LdlnU0rbEKHH8D5ZlHtzTpz3lWe";
//this is the home link
const home = "https://api.worldtradingdata.com/api/v1/stock?symbol=";
//the stocks we want data for
var stock = "AAPL,NVDA,FB,TSLA&sort_by=name&";
	
	
	
	
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
					document.write(request_time + " ms" + '<br>');
					stock_print(result["data"]);
				},
				error: function(error){
					console.log('Error ${error}')
				}
			})
			
		})
		
	})
	
	
	
	// prints the stock symbol and name, the price and volume for all stocks called. 
	function stock_print(result) {
		for (i = 0; i < result.length; i++) {
			document.write(result[i]["symbol"] + ":" + result[i]["name"] + " Price: " + 
					result[i]["price"] + " Volume: " + result[i]["volume"] + '<br>');
		}
		
	}