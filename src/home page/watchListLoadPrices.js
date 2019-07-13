//this is my API key
const keyToken = "api_token=Yo0mpIdLPhffFMpfbbn5QOfCIBsq5vnH3LdlnU0rbEKHH8D5ZlHtzTpz3lWe";
//this is the home link
const home = "https://intraday.worldtradingdata.com/api/v1/intraday?symbol=";

var arr = new Array();

getWatchList("testUser123");

//sets global array
function setArray(arr) {
	this.arr = arr;
}

//takes in username, queries sql for watch-list preferences, ajax api for prices
function getWatchList(username) {
	$.ajax({
		url: 'http://localhost/wsb/src/home page/watchListLoadPrices.php',
		type: 'post',
		dataType: 'json',
		data: {action : 'getWatchList', input : username},
		success: function(result){
			arr = result.watchList;
			setArray(arr);
			
			for (var i = 0; i < arr.length; i++) console.log(arr[i]);
			}
		});
	
	
}

function getPrices(watchList) {
	
	for (var i = 0; i < watchList.length; i++) {
		var Url = "https://intraday.worldtradingdata.com/api/v1/intraday?symbol=" + watchList[i];
		Url += "api_token=Yo0mpIdLPhffFMpfbbn5QOfCIBsq5vnH3LdlnU0rbEKHH8D5ZlHtzTpz3lWe";
		
		$.ajax({
			url: Url,
			type: "GET",
			success: function(result){
				
				
				
			},
			error: function(error){
				console.log('Error ${error}')
			}
		})
	}
}

