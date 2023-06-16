overviewDiv = document.querySelector(".overview");
areasoffocuswDiv = document.querySelector(".areas-of-focus");
patnershipsDiv = document.querySelector(".partnerships");
visionmissionDiv = document.querySelector(".vision");
corevaluesDiv = document.querySelector(".core-values");
successDiv = document.querySelector(".success-stories");
menuDiv = document.querySelector(".nav2");
menuIcon = document.querySelector(".menu-bars");

menuIcon.addEventListener("clic", function() {
    if (menuDiv.style.display="none") {
        menuDiv.style.display="block";
    } else if(menuDiv.style.display="block"){
        menuDiv.style.display="none";
    }
})

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