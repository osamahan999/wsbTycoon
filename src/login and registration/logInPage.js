

function logIn() {
	
	user = document.getElementsByName("username")[0].value; 
	pass = document.getElementsByName("password")[0].value;
	
	
	$.ajax({
		url: 'http://localhost/wsb/src/login%20and%20registration/logInPage.php',
		type: 'post',
		dataType: 'json', 
		data: {action : 'log_in', username: user, password: pass},
		success: function(result){
			loggedIn = result.isLogged;
			
			if (loggedIn) {
				sessionStorage.setItem("username", user) ;
			}
		}
      });
}