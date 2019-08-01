/**
 * searchBarQuery.js
 * Called each time someone types in the search bar. ajax requests searchBarSearch.php
 * with the text-box input as the parameter. this is then queried into our sql stocks table
 * for top 5 matches based on either symbol or name of the stock. returns those in an array.
 * this script then adds those items into divs and puts them on our page.
 * 
 * bug: list is choppy.
 * potential solutions: put the addToList function into the autocomplete function after ajax, and that
 * gets rid of the choppiness. however, that has another bug associated. first input doesnt do anything.
 */



//initializes our array
var arr = new Array();
//sets global array
function setArray(arr) {
	this.arr = arr;
}


function autocomplete(inp) {
  /*the autocomplete function takes one argument,
  the text field element*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted stocks*/
      closeAllLists();
      
      if (!val) { return false;}
      currentFocus = -1;
      
      //create a DIV element that will contain the items (values):
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      
      //append the new element as a child of the autocomplete container
      this.parentNode.appendChild(a);
      
      var searchTerm = inp.value;
      
      /*ajax requests top 5 matches from searchBarSearch.php, stores it in global array 'arr' 
       * searchBarSearch.php contains a function that builds a query and gets stocks from a database
       * hosted locally */
      $.ajax({
		url: 'http://localhost/wsb/src/home%20page/searchBar/searchBarSearch.php',
		type: 'post',
		dataType: 'json',
		data: {action : 'searchTable', input : searchTerm},
		success: function(result){
			arr = result.TopFiveStocks;
			setArray(arr);
			console.log("array gotten and set as 'arr'");
			addToList(a, b, i, arr);
		}
      });
      

      
  });
   
  function addToList(a, b, i, arr) {
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
    	  console.log("pointer hit for loop on line 46!");
    	  if (arr[i] !== null) {
    		  //create a DIV element for each element
    		  b = document.createElement("DIV");
    		  b.innerHTML = arr[i];
    		  
    		  //inserts the item's value
    		  b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
    		  
    		  //adds event listened to said div for onclick
    		  b.addEventListener("click", function(e) {
    			  //insert the value for the autocomplete text field
    			  inp.value = this.getElementsByTagName("input")[0].value;
    			  /*close the list of autocompleted values,
    			   * (or any other open lists of autocompleted values:*/
    			  closeAllLists();
    		  });
    	  a.appendChild(b);
    	  }
      }
  }
  
  //execute a function when keyboard pressed
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        
        //makes current item more active
        addActive(x);
      } else if (e.keyCode == 38) { //up
        currentFocus--;
        addActive(x);
      } else if (e.keyCode == 13) {
        //If the ENTER key is pressed, prevent the form from being submitted
        e.preventDefault();
        if (currentFocus > -1) {
          //simulate click on the "active" item
          if (x) x[currentFocus].click();
        }
      }
  });

  //classifies an element as active
  function addActive(x) {
    if (!x) return false;
    
    //remove "active" class on all items
    removeActive(x);
    
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    
    // add css autocomplete-active which makes it look highlighted
    x[currentFocus].classList.add("autocomplete-active");
  }
  
  //removes autocomplete-active css
  function removeActive(x) {
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  
  //closes all lists except argument
  function closeAllLists(elmnt) {
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
}
//closes lists when click
document.addEventListener("click", function (e) {
    closeAllLists(e.target);
});
} 
