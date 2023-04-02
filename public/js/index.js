let pain =new Map();
let pain_h =new Map();
  let queStions1 = function (questions) {

    let qstion = document.getElementsByName(questions);//Функция обрабатывающая первый вопрос.
    for (let radio of  qstion) {
        if (radio.checked) {
            pain.set(questions, Number(radio.value));

        }
    }


}
let nociceptionPain =0;
let ishemiaPain =0;
let neuropaticPain =0;
let sensitPain =0;
let dezingibitionPain=0;
let disfunPain =0;
let chronicPain=0;
function result(){

    pain.forEach(function(value,key){
       if(key.match(/(-?\d+(\.\d+)?)/g)[0]>=1 && key.match(/(-?\d+(\.\d+)?)/g)[0]<=7){

        nociceptionPain  = nociceptionPain + value;
       }
       if(key.match(/(-?\d+(\.\d+)?)/g)[0]>=8 && key.match(/(-?\d+(\.\d+)?)/g)[0]<=14){
        ishemiaPain= ishemiaPain+value;
       }
       if(key.match(/(-?\d+(\.\d+)?)/g)[0]>=15 && key.match(/(-?\d+(\.\d+)?)/g)[0]<=21){
        neuropaticPain= neuropaticPain +value;
       }
       if(key.match(/(-?\d+(\.\d+)?)/g)[0]>=22 && key.match(/(-?\d+(\.\d+)?)/g)[0]<=27){
        sensitPain= sensitPain +value;
       }
       if(key.match(/(-?\d+(\.\d+)?)/g)[0]>=28 && key.match(/(-?\d+(\.\d+)?)/g)[0]<=44){
        dezingibitionPain= dezingibitionPain +value;
       }
       if(key.match(/(-?\d+(\.\d+)?)/g)[0]>=46 && key.match(/(-?\d+(\.\d+)?)/g)[0]<=55){
        disfunPain = disfunPain +value;
       }
    })
    document.getElementById('nociceptionPain').value = nociceptionPain;
    document.getElementById('ishemiaPain').value = ishemiaPain;
    document.getElementById('neuropaticPain').value = neuropaticPain;
    document.getElementById('sensitPain').value =  sensitPain;
    document.getElementById('dezingibitionPain').value = dezingibitionPain;
    document.getElementById('disfunPain').value = disfunPain;
}


let queStions2 = function (questions) {
    let qstions = document.getElementsByName(questions);//Функция обрабатывающая первый вопрос.
    for (let radio of  qstions) {
        if (radio.checked) {
            pain_h.set(questions, Number(radio.value));

        }

    }


}
function resultChronicPain(){

    pain_h.forEach(function(value,key){
        chronicPain =  chronicPain + value;
    })

     document.getElementById("chronicPain").value =chronicPain*10;



}
