overviewDiv = document.querySelector(".overview");
areasoffocuswDiv = document.querySelector(".areas-of-focus");
patnershipsDiv = document.querySelector(".partnerships");
visionmissionDiv = document.querySelector(".vision");
corevaluesDiv = document.querySelector(".core-values");
successDiv = document.querySelector(".success-stories");
menuDiv = document.querySelector(".nav2");
menuIcon = document.querySelector(".menu-bars");
cancelIcon = document.querySelector(".cancel-bars");
phoneNav = document.querySelector(".nav2");


  
  

menuIcon.addEventListener("click", function() {
        menuDiv.style.display="block";
        cancelIcon.style.display="block";
        menuIcon.style.display="none";
});

cancelIcon.addEventListener("click", function() {
        menuDiv.style.display="none";
        menuIcon.style.display="block";
        cancelIcon.style.display="none";
});

function displayOverviewDiv(){
    overviewDiv.style.display="block";
    areasoffocuswDiv.style.display="none";
    patnershipsDiv.style.display="none";
    visionmissionDiv.style.display="none";
    corevaluesDiv.style.display="none";
    successDiv.style.display="none";
}
 
function displayAreasoffocusDiv(){
    overviewDiv.style.display="none";
    areasoffocuswDiv.style.display="block";
    patnershipsDiv.style.display="none";
    visionmissionDiv.style.display="none";
    corevaluesDiv.style.display="none";
    successDiv.style.display="none";
}

function displaypartnershipsDiv(){
    overviewDiv.style.display="none";
    areasoffocuswDiv.style.display="none";
    patnershipsDiv.style.display="block";
    visionmissionDiv.style.display="none";
    corevaluesDiv.style.display="none";
    successDiv.style.display="none";
}

function displayVisionmissionDiv(){
    overviewDiv.style.display="none";
    areasoffocuswDiv.style.display="none";
    patnershipsDiv.style.display="none";
    visionmissionDiv.style.display="block";
    corevaluesDiv.style.display="none";
    successDiv.style.display="none";
}

function displayCorevaluesDiv(){
    overviewDiv.style.display="none";
    areasoffocuswDiv.style.display="none";
    patnershipsDiv.style.display="none";
    visionmissionDiv.style.display="none";
    corevaluesDiv.style.display="block";
    successDiv.style.display="none";
}
function displaySuccessDiv(){
    overviewDiv.style.display="none";
    areasoffocuswDiv.style.display="none";
    patnershipsDiv.style.display="none";
    visionmissionDiv.style.display="none";
    corevaluesDiv.style.display="none";
    successDiv.style.display="block";
}
