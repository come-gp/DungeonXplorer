var currentTab = 0; 
var forms = document.getElementsByClassName("form-group");
var steps = document.getElementsByClassName("step");
showTab(currentTab); 


function showTab(n) {
   
    forms[n].style.display = "block";
  
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (forms.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Submit";
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
    }

    steps[n].className += " active";
}

function nextPrev(n) {
    
  
    forms[currentTab].style.display = "none";
  
    currentTab = currentTab + n;
  
    if (currentTab >= forms.length) {
        document.getElementById("newGameForm").submit();
        return false;
    }
  
    showTab(currentTab);
}





