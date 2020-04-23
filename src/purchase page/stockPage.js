
console.log(getStock());

/**
 * Returns the stock in the URL
 * I cant find proper http handling in JS for the life of me which is concerning!!!!
 * @returns
 */
function getStock() {
	const stock = window.location.search.split('=')[1];
	return stock;
}

function getStockData() {
	console.log("getStockData called");
	
	const theStock = getStock();
	
	$.ajax({
		url: 'http://localhost/wsb/src/YahooAPI/getCurrentData.php',
		type: 'post',
		dataType: 'json', 
		data: {stock : theStock},
		success: function(result){
			console.log("it worked");
			
			document.getElementById("stockPrice").innerHTML = "$" + result.price;
			document.getElementById("amtChanged").innerHTML = result.posOrNeg + result.amt;
			document.getElementById("percent").innerHTML = result.posOrNeg + result.percent + "%";

			
		}
	});	
}



function getFaceData() {
	console.log("getFaceData called");
	
	$.ajax({
		url: 'http://localhost/wsb/src/home%20page/home.php',
		type: 'post',
		dataType: 'json', 
		data: {action : 'getTotalMoneyAndUserID'},
		success: function(result){
			console.log("getTotalMoneyAndUserID ajax success BAYBE!");
			totalMoney = result.totalMoney;
			username = result.username;
			document.getElementById("money").innerHTML = "$" + totalMoney;
			document.getElementById("account").innerHTML = username;
		}
	});	
}


function checkLoggedIn() {
	console.log("check logged called");
	
	$.ajax({
		url: 'http://localhost/wsb/src/home%20page/home.php',
		type: 'post',
		dataType: 'json', 
		data: {action : 'logIn'},
		success: function(result){
			loggedIn = result.isLogged;
			console.log(loggedIn);
		
			if (loggedIn) {
				console.log("YOURE LOGGED IN BAYBE home.js/26");
				getFaceData();
			} else {
				console.log("log in failed")
				return window.location.href='http://localhost/wsb/src/login%20and%20registration/logInPage.html';

			}
		}
	});
}