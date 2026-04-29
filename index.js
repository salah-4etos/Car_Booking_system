const allcarsButton = document.getElementById('allcarsButton');
const editecarButton = document.getElementById('editecarButton');
const addcarButton = document.getElementById('addcarButton');
const editecarForm =  document.getElementById('editecarButton');
const allcarsForm = document.getElementById('allcarsButton');
const addcarForm = document.getElementById('addcarButton');

allcarsButton.addEventListener('click',function(){
    editecarForm.style.display="none";
    allcarsForm.style.display="Block";
    addcarForm.style.display="none";
})

editecarButton.addEventListener('click',function(){
    editecarForm.style.display="block";
    addcarForm.style.display="none";
    allcarsForm.style.display="none";
})

addcarButton.addEventListener('click',function(){
    addcarForm.style.display="block";
    allcarsForm.style.display="none";
    editecarForm.style.display="none";
})