

function getOwnedStocks() {
	const username = $("#account").text();


	$.ajax({
		url: 'http://localhost/wsb/src/home page/home.php',
		type: 'post',
		dataType: 'json', 
		data: {username: username, action: "getOwned"},
		success: function(result){
			console.log("get stocks called");
			result = result.result; //I know. don't laugh.
			
			$('#ownedStocks').empty();

			
			/**
			 * Prints the purchase to the page
			 */
			for(var x = 0; x < result.length; x++){ 
				
				const stock = result[x][1];
				const amt = result[x][4];
				const priceAtPurchase = result[x][3];
				const time = result[x][5];
				const str = "<div><p>stock:" + stock + " amt:" + amt + " price at purchase:" + priceAtPurchase + " at time:" + time + "<\/p><\/div><br>" ;
				
				$('#ownedStocks').append(str);  
			} 




		}
	})
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
			getOwnedStocks();
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