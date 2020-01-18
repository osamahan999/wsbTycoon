
function purchaseStock() {

	console.log("purchase stock callled");
	
	
    stock = document.getElementById("myStock").value;
    amt  = document.getElementById("amt").value;

    //this doesnt work for some reason?
    username = sessionStorage.getItem("username");
        
    $.ajax({
		url: 'http://localhost/wsb/src/stockPurchase/stockPurchase.php',
		type: 'post',
		dataType: 'json', 
		data: {action : 'purchaseStock', username: username, stock: stock, amt:amt},
		success: function(result){
			
		}
      });
}
