/*
*Inputs should be: 
* a: stock symbol
* b: quantity bought
* c: time transaction input
* d: user purchasing
*
* returns:
* if users doesnt exist, redirects to login page
* if amt < 0 not good
* 
* if logged in and amt > 0, get price of stock, check to see if user has enough cash for amt of stock. 
* if has enough, finish purchase and give user the stock and add it to purchase transaction
* if not enough, print message error
*/

//validate form data

function getStockPrice(stock) {
	//ajax or check cookies for stock prices
}




function purchaseStock() {
	var formIns = document.getElementById("stockPurchaseForm");
	
	
	console.log("You want " + formIns[1] + " of " + formIns[0]);
}

function getUserCash(username) {
	
	//call php script that returns caash amt
	
}

function canTheyBuy(stockPrice, userCash, quantity) {
	if ((stockPrice * quantity) >= userCash) {
		//ajax php script to remove that amount of money from the users account
		//also add transaction to transactions table
	} else {
		//print not enough cash!
	}
}
