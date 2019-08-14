
function loadMoney() {
	$.ajax({
		url: 'http://localhost/wsb/src/home%20page/home.php',
		type: 'post',
		dataType: 'json', 
		data: {action : 'getMoney'},
		success: function(result){
			totalMoney = result.totalMoney;
			document.getElementById("money").innerHTML = totalMoney;
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
				loadMoney();
			} else {
				return window.location.href='http://localhost/wsb/src/login%20and%20registration/logInPage.html';

			}
		}
	});
}