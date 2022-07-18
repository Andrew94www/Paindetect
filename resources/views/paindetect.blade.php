<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="/css/pain.css">
    <script src="/js/script.js"></script>
</head>

<body style='overflow-x:hidden;'>
	<header>
		<div class="logo">
			<div class="logos">
				<img src="img/logotip.png" width="250" height="65">
			</div>

			<div class="interview">
				<span>ОПРОСНИК ПО БОЛИ</span>
			</div>
		</div>
	</header>
	<form action="{{route('createpatient')}}" id="form" method="POST">
        @csrf
		<div class="content">

			<div class="severity">
				<p>Как бы Вы оценили интенсивность боли, которую испытываете <b>сейчас</b>, в настоящий момент?</p>

				<ul class="lis">
					<li>
						<p>1(min)<input type="radio" name="questions1" id="" value="1"></p>
					</li>
					<li>
						<p>2<input type="radio" name="questions1" id="" value="2"></p>
					</li>
					<li>
						<p>3<input type="radio" name="questions1" id="" value="3"></p>
					</li>
					<li>
						<p>4<input type="radio" name="questions1" id="" value="4"></p>
					</li>
					<li>
						<p>5<input type="radio" name="questions1" id="" value="5"></p>
					</li>
					<li>
						<p>6<input type="radio" name="questions1" id="" value="6"></p>
					</li>
					<li>
						<p>7<input type="radio" name="questions1" id="" value="7"></p>
					</li>
					<li>
						<p>8<input type="radio" name="questions1" id="" value="8"></p>
					</li>
					<li>
						<p>9<input type="radio" name="questions1" id="" value="9"></p>
					</li>
					<li>
						<p>10(max)<input type="radio" name="questions1" id="" value="10"></p>
					</li>

				</ul>
				<br>

				<p>Как бы Вы оценили интенсивность <b>наиболее сильного приступа </b> боли за последние 4 недели?</p>


				<ul class="lis">
					<li>
						<p>1(min)<input type="radio" name="questions2" id="" value="1"></p>
					</li>
					<li>
						<p>2<input type="radio" name="questions2" id="" value="2"></p>
					</li>
					<li>
						<p>3<input type="radio" name="questions2" id="" value="false"></p>
					</li>
					<li>
						<p>4<input type="radio" name="questions2" id="" value="4"></p>
					</li>
					<li>
						<p>5<input type="radio" name="questions2" id="" value="5"></p>
					</li>
					<li>
						<p>6<input type="radio" name="questions2" id="" value="6"></p>
					</li>
					<li>
						<p>7<input type="radio" name="questions2" id="" value="7"></p>
					</li>
					<li>
						<p>8<input type="radio" name="questions2" id="" value="8"></p>
					</li>
					<li>
						<p>9<input type="radio" name="questions2" id="" value="9"></p>
					</li>
					<li>
						<p>10(max)<input type="radio" name="questions2" id="" value="10"></p>
					</li>
				</ul>
				<br>
				<p> <b>В среднем</b>, насколько сильной была боль в течение последних 4 недель?</p>

				<ul class="lis">
					<li>
						<p class="1">1(min)<input type="radio" name="questions3" id="" value="1"></p>
					</li>
					<li>
						<p class="2">2<input type="radio" name="questions3" id="" value="2"></p>
					</li>
					<li>
						<p class="3">3<input type="radio" name="questions3" id="" value="3"></p>
					</li>
					<li>
						<p class="4">4<input type="radio" name="questions3" id="" value="4"></p>
					</li>
					<li>
						<p class="5">5<input type="radio" name="questions3" id="" value="5"></p>
					</li>
					<li>
						<p class="6">6<input type="radio" name="questions3" id="" value="6"></p>
					</li>
					<li>
						<p class="7">7<input type="radio" name="questions3" id="" value="7"></p>
					</li>
					<li>
						<p class="8">8<input type="radio" name="questions3" id="" value="8"></p>
					</li>
					<li>
						<p class="9">9<input type="radio" name="questions3" id="" value="9"></p>
					</li>
					<li>
						<p class="10">10(max)<input type="radio" name="questions3" id="" value="10"></p>
					</li>
				</ul>

				<div class="imagespainss">

					<b>Отметьте картинку, которая наиболее точно отражает характер протекания боли в Вашем случае:</b>

					<div class="imagespain">
						<p><img src="img/paingrafic.png" alt="" class="leftimg">Непрерывная боль, немного меняющаяся по
							интенсивности <input type="radio" name="imaga" id="" value="1" onchange="quesimg()"></p>
					</div> <br><br><br>
					<div class="imagespain1">
						<p><img src="img/paingrafic1.png" alt="" class="leftimg">Непрерывная боль спериодическими
							приступами <input type="radio" name="imaga" id="" value="2" onchange="quesimg()"></p></span>
					</div><br><br><br>
					<div class="imagespain2">
						<p><img src="img/paingrafic2.png" alt="" class="leftimg">Приступы боли без болевых ощущений в
							промежутках между ними <input type="radio" name="imaga" id="" value="3"
								onchange="quesimg()"></p>
					</div><br><br>
					<div class="imagespain2">
						<p><img src="img/paingrafic3.png" alt="" class="leftimg">Приступы боли, сопровождающиеся
							болевыми ощущениями в промежутках между ними <input type="radio" name="imaga" id=""
								value="4" onchange="quesimg()"></p>
					</div><br><br>

				</div>





			</div>


			<div class="mans">
				<p>Пожалуйста, укажите на рисунке <b>одну область</b>, где вы испытываете <b>наиболее сильную боль.</b>
				</p>
				<img src="img/painDETECT.png.png" width="450" height="400" id="replacement">
				<p>Отдает ли боль в другие области тела?</p>
				<button class="button1" type="button" onclick="qustionmans()">Да</button>
				<button class="button2" type="button" onclick="qustionmans()">Нет</button>

				<p>Если отдает, укажите пожалуйста область.</p>

				<ul class="region">
					<br>
					<li>
						<p class="1">Область №1<input type="radio" name="questions11" id="" value="1"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="">Область №11<input type="radio" name="questions11" id="" value="11"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="">Область №21<input type="radio" name="questions11" id="" value="21"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="">Область №2<input type="radio" name="questions11" id="" value="2"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="">Область №12<input type="radio" name="questions11" id="" value="12"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="6">Область №22<input type="radio" name="questions11" id="" value="22"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №3<input type="radio" name="questions11" id="" value="3"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="8">Область №13<input type="radio" name="questions11" id="" value="13"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="10">Область №23<input type="radio" name="questions11" id="" value="23"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="4">Область №4<input type="radio" name="questions11" id="" value="4"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="5">Область №14<input type="radio" name="questions11" id="" value="14"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="6">Область №24<input type="radio" name="questions11" id="" value="24"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №5<input type="radio" name="questions11" id="" value="5"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №15<input type="radio" name="questions11" id="" value="15"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №25<input type="radio" name="questions11" id="" value="25"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №6<input type="radio" name="questions11" id="" value="6"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №16<input type="radio" name="questions11" id="" value="16"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №26<input type="radio" name="questions11" id="" value="26"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №7<input type="radio" name="questions11" id="" value="7"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №17<input type="radio" name="questions11" id="" value="17"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №27<input type="radio" name="questions11" id="" value="27"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №8<input type="radio" name="questions11" id="" value="8"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №18<input type="radio" name="questions11" id="" value="18"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №28<input type="radio" name="questions11" id="" value="28"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №9<input type="radio" name="questions11" id="" value="9"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №19<input type="radio" name="questions11" id="" value="19"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №29<input type="radio" name="questions11" id="" value="29"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №10<input type="radio" name="questions11" id="" value="10"
								onchange="changePictche(changeCount())"></p>
					</li>
					<li>
						<p class="7">Область №20<input type="radio" name="questions11" id="" value="20"
								onchange="changePictche(changeCount())"></p>
					</li>


				</ul>

			</div>

		</div>
		<div class="resalt">
			<div class="severityend">
				<b>Испытываете ли Вы ощущение жжения (например, как при ожоге крапивой) в области, которую отметили на
					рисунке?</b>
				<br>

				<ul class="lis">
					<li>
						<p>совсем нет<input type="radio" name="questions4" id="" onchange="questions4()" value="0"></p>
					</li>
					<li>
						<p>едва заметное<input type="radio" name="questions4" id="" onchange="questions4()" value="1"></p>
					</li>
					<li>
						<p>незначительноe<input type="radio" name="questions4" id="" onchange="questions4()" value="2"></p>
					</li>
					<li>
						<p>умеренное<input type="radio" name="questions4" id="" onchange="questions4()" value="3"></p>
					</li>
					<li>
						<p>сильное<input type="radio" name="questions4" id="" onchange="questions4()" value="4"></p>
					</li>
					<li>
						<p>очень сильное<input type="radio" name="questions4" id="" onchange="questions4()" value="5"></p>
					</li>


				</ul>
				<br>

				<b>Ощущаете ли Вы покалывание или пощипывание в области боли (как покалывание от онемения или слабого
					электрического тока)?</b>
				<br>


				<ul class="lis">
					<li>
						<p>совсем нет<input type="radio" name="questions5" id="" onchange="questions5()" value="0"></p>
					</li>
					<li>
						<p>едва заметное<input type="radio" name="questions5" id="" onchange="questions5()" value="1"></p>
					</li>
					<li>
						<p>незначительноe<input type="radio" name="questions5" id="" onchange="questions5()" value="2"></p>
					</li>
					<li>
						<p>умеренное<input type="radio" name="questions5" id="" onchange="questions5()" value="3"></p>
					</li>
					<li>
						<p>сильное<input type="radio" name="questions5" id="" onchange="questions5()" value="4"></p>
					</li>
					<li>
						<p>очень сильное<input type="radio" name="questions5" id="" onchange="questions5()" value="5"></p>
					</li>
				</ul>
				<br>
				<b> Возникают ли у Вас болезненные ощущения в указанной области при легком соприкосновении (содеждой,
					одеялом)?</b>
				<br>

				<ul class="lis">
					<li>
						<p>совсем нет<input type="radio" name="questions6" id="" onchange="questions6()" value="0"></p>
					</li>
					<li>
						<p>едва заметное<input type="radio" name="questions6" id="" onchange="questions6()" value="1"></p>
					</li>
					<li>
						<p>незначительноe<input type="radio" name="questions6" id="" onchange="questions6()" value="2"></p>
					</li>
					<li>
						<p>умеренное<input type="radio" name="questions6" id="" onchange="questions6()" value="3"></p>
					</li>
					<li>
						<p>сильное<input type="radio" name="questions6" id="" onchange="questions6()" value="4"></p>
					</li>
					<li>
						<p>очень сильное<input type="radio" name="questions6" id="" onchange="questions6()" value="5"></p>
					</li>
				</ul>
				<br>
				<b>Возникают ли у Вас резкие приступы боли в указанной области, как удар током?</b>
				<br>

				<ul class="lis">
					<li>
						<p>совсем нет<input type="radio" name="questions7" id="" onchange="questions7()" value="0"></p>
					</li>
					<li>
						<p>едва заметное<input type="radio" name="questions7" id="" onchange="questions7()" value="1"></p>
					</li>
					<li>
						<p>незначительноe<input type="radio" name="questions7" id="" onchange="questions7()" value="2"></p>
					</li>
					<li>
						<p>умеренное<input type="radio" name="questions7" id="" onchange="questions7()" value="3"></p>
					</li>
					<li>
						<p>сильное<input type="radio" name="questions7" id="" onchange="questions7()" value="4"></p>
					</li>
					<li>
						<p>очень сильное<input type="radio" name="questions7" id="" onchange="questions7()" value="5"></p>
					</li>

				</ul>
				<br>

				<b>Возникают ли у Вас иногда болезненные ощущения в указанной области при воздействии холодного или
					горячего (например, воды, когда Вы моетесь)?</b>
				<br>


				<ul class="lis">
					<li>
						<p>совсем нет<input type="radio" name="questions8" id="" onchange="questions8()" value="0"></p>
					</li>
					<li>
						<p>едва заметное<input type="radio" name="questions8" id="" onchange="questions8()" value="1"></p>
					</li>
					<li>
						<p>незначительноe<input type="radio" name="questions8" id="" onchange="questions8()" value="2"></p>
					</li>
					<li>
						<p>умеренное<input type="radio" name="questions8" id="" onchange="questions8()" value="3"></p>
					</li>
					<li>
						<p>сильное<input type="radio" name="questions8" id="" onchange="questions8()" value="4"></p>
					</li>
					<li>
						<p>очень сильное<input type="radio" name="questions8" id="" onchange="questions8()" value="5"></p>
					</li>
				</ul>
				<br>
				<b> Ощущаете ли Вы онемение в указанной области?</b>
				<br>

				<ul class="lis">
					<li>
						<p>совсем нет<input type="radio" name="questions9" id="" onchange="questions9()" value="0"></p>
					</li>
					<li>
						<p>едва заметное<input type="radio" name="questions9" id="" onchange="questions9()" value="1"></p>
					</li>
					<li>
						<p>незначительноe<input type="radio" name="questions9" id="" onchange="questions9()" value="2"></p>
					</li>
					<li>
						<p>умеренное<input type="radio" name="questions9" id="" onchange="questions9()" value="3"></p>
					</li>
					<li>
						<p>сильное<input type="radio" name="questions9" id="" onchange="questions9()" value="4"></p>
					</li>
					<li>
						<p>очень сильное<input type="radio" name="questions9" id="" onchange="questions9()" value="5"></p>
					</li>
				</ul>
				<br>

				<b> Вызывает ли боль легкое нажатие на указанную область, например, нажатие пальцем?</b>
				<br>
				<ul class="lis">
					<li>
						<p>совсем нет<input type="radio" name="questions10" id="" onchange="questions10()" value="0"></p>
					</li>
					<li>
						<p>едва заметное<input type="radio" name="questions10" id="" onchange="questions10()" value="1"></p>
					</li>
					<li>
						<p>незначительноe<input type="radio" name="questions10" id="" onchange="questions10()" value="2"></p>
					</li>
					<li>
						<p>умеренное<input type="radio" name="questions10" id="" onchange="questions10()" value="3"></p>
					</li>
					<li>
						<p>сильное<input type="radio" name="questions10" id="" onchange="questions10()" value="4"></p>
					</li>
					<li>
						<p>очень сильное<input type="radio" name="questions10" id="" onchange="questions10()" value="5"></p>
					</li>
				</ul>
				<br>
				<br>
				<div class="culculate">
					<span><textarea name="result" cols="80" rows="5" id="myText" >0</textarea></span>
					<button class="button1" onclick="resalt(summa ())">Результат обследования</button>
				</div>
			</div>
	</form>
	<script type="text/javascript" src="js/script.js"></script>
</body>

</html>
