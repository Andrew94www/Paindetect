
let qustionmans = function () {
    return 2;
}


let quesimg = function () {
    let qstion = document.getElementsByName('imaga');//Функция обрабатывающая  вопрос  с картинками.
    for (let i = 0; i < qstion.length; i++) {
        if (qstion[i].checked) {
            if (i === 0) {
                return 0;
            }
            else if (i === 1) {
                return -1;

            }
            else if (i === 2 || i === 3) {
                return 1;
            }
        }
    }

}







let questions4 = function () {
    let qstion = document.getElementsByName('questions4');//Функция обрабатывающая первый вопрос.
    for (let i = 0; i < qstion.length; i++) {
        if (qstion[i].checked) {
            count = i;
            return count;
        }
    }

}



let questions5 = function () {
    let qstion = document.getElementsByName('questions5');//Функция обрабатывающая второй вопрос.
    for (let i = 0; i < qstion.length; i++) {
        if (qstion[i].checked) {
            count = i;
            return count;
        }
    }

}



let questions6 = function () {
    let qstion = document.getElementsByName('questions6');//Функция обрабатывающая третий вопрос.
    for (let i = 0; i < qstion.length; i++) {
        if (qstion[i].checked) {
            count = i;
            return count;
        }
    }

}



let questions7 = function () {
    let qstion = document.getElementsByName('questions7');//Функция обрабатывающая четвкртый вопрос.
    for (let i = 0; i < qstion.length; i++) {
        if (qstion[i].checked) {
            count = i;
            return count;
        }
    }

}



let questions8 = function () {
    let qstion = document.getElementsByName('questions8');//Функция обрабатывающая пятый вопрос.
    for (let i = 0; i < qstion.length; i++) {
        if (qstion[i].checked) {
            count = i;
            return count;
        }
    }

}


let questions9 = function () {
    let qstion = document.getElementsByName('questions9');//Функция обрабатывающая шестой вопрос.
    for (let i = 0; i < qstion.length; i++) {
        if (qstion[i].checked) {
            count = i;
            return count;
        }
    }

}


let questions10 = function () {
    let qstion = document.getElementsByName('questions10');//Функция обрабатывающая сидьмой вопрос.
    for (let i = 0; i < qstion.length; i++) {
        if (qstion[i].checked) {
            count = i;
            return count;
        }
    }

}




//Функция счетчик.
function changeCount() {
    let image = document.getElementsByName('questions11');
    for (let i = 0; i < image.length; i++) {
        if (image[i].checked) {
            count = i + 1;

            return count;
        }
    }
}
/*Функция замены картинки*/
function changePictche(count) {
    switch (count) {
        case 1:
            document.getElementById('replacement').src = "img/painDETECT1.png";
            break;
        case 2:
            document.getElementById('replacement').src = "img/painDETECT20.png";
            break;
        case 3:
            document.getElementById('replacement').src = "img/painDETECT26.png";
            break;
        case 4:
            document.getElementById('replacement').src = "img/painDETECT2.png"
            break;
        case 5:
            document.getElementById('replacement').src = "img/painDETECT19.png"
            break;
        case 6:
            document.getElementById('replacement').src = "img/painDETECT27.png"
            break;
        case 7:
            document.getElementById('replacement').src = "img/painDETECT15.png"
            break;
        case 8:
            document.getElementById('replacement').src = "img/painDETECT21.png"
            break;
        case 9:
            document.getElementById('replacement').src = "img/painDETECT25.png"
            break;
        case 10:
            document.getElementById('replacement').src = "img/painDETECT16.png"
            break;
        case 11:
            document.getElementById('replacement').src = "img/painDETECT22.png"
            break;
        case 12:
            document.getElementById('replacement').src = "img/painDETECT13.png"
            break;
        case 13:
            document.getElementById('replacement').src = "img/painDETECT17.png"
            break;
        case 14:
            document.getElementById('replacement').src = "img/painDETECT23.png"
            break;
        case 15:
            document.getElementById('replacement').src = "img/painDETECT14.png"
            break;
        case 16:
            document.getElementById('replacement').src = "img/painDETECT18.png"
            break;
        case 17:
            document.getElementById('replacement').src = "img/painDETECT24.png"
            break;
        case 18:
            document.getElementById('replacement').src = "img/painDETECT31.png"
            break;
        case 19:
            document.getElementById('replacement').src = "img/painDETECT4.png"
            break;
        case 20:
            document.getElementById('replacement').src = "img/painDETECT8.png"
            break;
        case 21:
            document.getElementById('replacement').src = "img/painDETECT29.png"
            break;
        case 22:
            document.getElementById('replacement').src = "img/painDETECT5.png"
            break;
        case 23:
            document.getElementById('replacement').src = "img/painDETECT9.png"
            break;
        case 24:
            document.getElementById('replacement').src = "img/painDETECT28.png"
            break;
        case 25:
            document.getElementById('replacement').src = "img/painDETECT6.png"
            break;
        case 26:
            document.getElementById('replacement').src = "img/painDETECT11.png"
            break;
        case 27:
            document.getElementById('replacement').src = "img/painDETECT30.png"
            break;
        case 28:
            document.getElementById('replacement').src = "img/painDETECT7.png"
            break;
        case 29:
            document.getElementById('replacement').src = "img/painDETECT12.png"
            break;


    }
}

function summa() {

    let sum = qustionmans() + quesimg() + questions4() + questions5() + questions6() + questions7() + questions8() + questions9() + questions10();
    if (isNaN(sum)) {
        alert('Вы  ответили не на все вопросы, вернитесь и ответе на все вопросы!')

    }
    return sum;


}
//document.getElementById('myText').innerHTML = 'didididi'
function resalt(sum) {


    if (sum >= 0 && sum <= 12) {
        document.getElementById('myText').innerHTML = '15'
    }
    else if (sum >= 13 && sum <= 16) {
        document.getElementById('myText').innerHTML = '45'

    }
    else if (sum >= 17 && sum <= 18) {
        document.getElementById('myText').innerHTML = '50'
    }
    else if (sum >= 19 && sum <= 38) {
        document.getElementById('myText').innerHTML = '90'
    }
}



// function resalt1(sum) {


//     if (sum >= 0 && sum <= 12) {
//         document.getElementById('myText1').innerHTML = 'Лечение не требуеться'
//     }
//     else if (sum >= 13 && sum <= 16) {
//         document.getElementById('myText1').innerHTML = 'Rp.:Nimesulidi 0,1\nD. t. d. № 10 in tab. (pulv.)\nS.По 1 табл. (порошку) 2 раза в день;\n  содержимое порошка растворив в 1/2 стакана теплой воды\nПринимать на протяжении 5 дней.'

//     }
//     else if (sum >= 17 && sum <= 18) {
//         document.getElementById('myText1').innerHTML = 'Rp.: Caps. Pregabalini 0.075\nD.t.d.N 84\nS. по 1 капсуле * 1 раза в день'
//     }
//     else if (sum >= 19 && sum <= 24) {
//         document.getElementById('myText1').innerHTML = `Rp:Tab. Diclofenaci 0,025\nD.t.d.N. 30\nS. Принимать перорально по 1 таблетке 3 раза в сутки.
//         \nRp.: Caps. Pregabalini 0.075\nD.t.d.N 84\nS. по 1 капсуле * 1 раза в день
//         \nRp. Pyridoxini 0,01\nD. t. d. N. 10 in tab.\nS. По 1 таблетка 1 раз в день.\nЛекарственные препараты принимать на протяжении 14 дней.

//        `
//     }
//     else if (sum >= 25 && sum <= 29) {
//         document.getElementById('myText1').innerHTML = `Rp:Tab. Diclofenaci 0,025\nD.t.d.N. 30\nS. Принимать перорально по 1 таблетке 3 раза в сутки.
//         \nRp.: Caps. Pregabalini 0.075\nD.t.d.N 84\nS. по 1 капсуле * 1 раза в день на протяжение первых 3 дней с 4 по 14 день 2 капс. 150 мг 2 раза в день
//         \nRp. Pyridoxini 0,01\nD. t. d. N. 10 in tab.\nS. По 1 таблетка 1 раз в день.\nЛекарственные препараты принимать на протяжении 14 дней.`
//     }
//     else if (sum >= 30 && sum <= 33) {
//         document.getElementById('myText1').innerHTML = `Rp: Sol. Diclofenaci 2,5 % - 3 ml\nS: Внутримышечно по 3 мл. в день..
//         \nRp.: Caps. Pregabalini 0.075\nD.t.d.N 84\nS. по 1 капсуле * 1 раза в день на протяжение первых 3 дней с 4 по 14 день 2 капс. 150 мг 2 раза в день
//         \nRp. Pyridoxini 0,01\nD. t. d. N. 10 in tab.\nS. По 1 таблетка 1 раз в день.\nЛекарственные препараты принимать на протяжении 14 дней.`
//     }
//     else if (sum >= 34 && sum <= 38) {
//         document.getElementById('myText1').innerHTML = `Rp: Sol. Diclofenaci 2,5 % - 3 ml\nS: Внутримышечно по 3 мл. в день..
//         \nRp.: Caps. Pregabalini 0.075\nD.t.d.N 84\nS. по 1 капсуле * 1 раза в день на протяжение первых 3 дней с 4 по 14 день 2 капс. 150 мг 2 раза в день
//         \nRp. Pyridoxini 0,01\nD. t. d. N. 10 in tab.\nS. По 1 таблетка 1 раз в день.
//         \nRp: Tramadoli 0,05\nD.t.d № 20 in tab.\nS. По 1 табл. 2 раза в день на протяжении 7 дней.
//         \nЛекарственные препараты принимать на протяжении 14 дней.`
//     }
// }
