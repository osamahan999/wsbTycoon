
function purchaseStock() {

    stock = document.getElementById("myStock").value;
    amt  = document.getElementById("amt").value;

		//Writing submission to innerHTML
    document.getElementById("output").innerHTML = "The stock is " + stock + " and the amount is " + amt ".";
}
