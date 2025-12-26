var currentTab = 0; 
var forms = document.getElementsByClassName("form-group");
var steps = document.getElementsByClassName("step");

showTab(currentTab); 


function showTab(n) {

    // Cacher tous les form-groups et retirer la classe active de tous les steps
    for (let i = 0; i < forms.length; i++) {
        forms[i].style.display = "none";
        steps[i].className = steps[i].className.replace(" active", "");
    }
    
    // Afficher le form-group actuel
   
    forms[n].style.display = "block";
    
  
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (forms.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Valider";
    } else {
        document.getElementById("nextBtn").innerHTML = "Suivant";
    }

    steps[n].className += " active";
}

function nextPrev(n) {
    // Validation avant de passer à l'étape suivante
    if (n === 1 && !validateCurrentTab()) {
        return false;
    }
    
    forms[currentTab].style.display = "none";
  
    currentTab = currentTab + n;
  
    if (currentTab >= forms.length) {
        document.getElementById("newGameForm").submit();
        return false;
    }
  
    showTab(currentTab);
}

function validateCurrentTab() {
    // Étape 0 : validation du nom du héros
    if (currentTab === 0) {
        const heroName = document.getElementById("hero_name").value.trim();
        if (!heroName) {
            alert("Veuillez entrer un nom pour votre héros");
            return false;
        }
        if (heroName.length < 3) {
            alert("Le nom doit contenir au minimum 3 caractères");
            return false;
        }
        return true;
    }
    
    // Étape 1 : validation de la classe
    if (currentTab === 1) {
        const classSelected = document.querySelector('input[name="class_id"]:checked');
        if (!classSelected) {
            alert("Veuillez sélectionner une classe");
            return false;
        }
        return true;
    }
    
    // Étape 2 : biographie optionnelle, pas de validation
    return true;
}



let slides = document.querySelectorAll('.slide');

let currentSlide = 0;

showSlide(currentSlide);

function showSlide(n) {
   
    slides[n].style.display = "block";
  
    slides[n].className += " active";

}

function nextPrevSlide(n) {
    
  
    slides[currentSlide].style.display = "none";
  
    currentSlide = currentSlide + n;

    if (currentSlide >= slides.length) {
        currentSlide = 0 ;
    }
    if (currentSlide < 0) {
        currentSlide = slides.length - 1 ;
    }
  
    showSlide(currentSlide);
}