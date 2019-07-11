var arr = new Array();
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
			}
		});
	
	
}

function getPrices(watchList) {
	$.ajax({
		url: Url,
		type: "GET",
		success: function(result){
			
			//calls urlBuilder
			//store price in array
			
		},
		error: function(error){
			console.log('Error ${error}')
		}
	})
}


//takes array and builds it into the url api
function urlBuilder(watchList) {
	
}