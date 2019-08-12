

function logIn() {
	
	
	$(function() { //shorthand document.ready function
	    $('#login_form').on('submit', function(e) { //use on if jQuery 1.7+
	        e.preventDefault();  //prevent form from submitting
	        
	        //form data
	    	user = document.getElementsByName("username")[0].value; 
	    	pass = document.getElementsByName("password")[0].value;
	    	
	    	//gets boolean from php file if logged in. 
	    	$.ajax({
				url: 'http://localhost/wsb/src/login%20and%20registration/logInPage.php',
				type: 'post',
				dataType: 'json', 
				data: {action : 'log_in', username: user, password: pass},
				success: function(result){
					loggedIn = result.isLogged;
					console.log(loggedIn);
				
					if (loggedIn) {
						localStorage.setItem('username', user) ;
						console.log("Local storage worked! Your username is " + localStorage.getItem('username'));
					
						//sends you to home page.
						return window.location.href='http://localhost/wsb/src/home%20page/home.html';
					} else {
						console.log("logInPage.js problem logged in");
						alert("Wrong login information.");
					}
				}
			});
	    });
	});
}