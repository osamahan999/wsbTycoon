
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
				return window.location.href='http://localhost/wsb/src/login%20and%20registration/logInPage.html';

			}
		}
	});
}