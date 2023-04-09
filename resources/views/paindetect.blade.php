<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PAINDETECT</title>
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
				<span>@lang('main.pain_questioner')</span>
			</div>
		</div>
	</header>
	<form action="{{route('createpatient')}}" id="form" method="POST">
        @csrf
		<div class="content">

			<div class="severity">
				<p>@lang('main.would_you_assess')</p>

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

				<p>@lang('main.was_the_strongest')</p>


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
				<p> @lang('main.weeks_on_average')</p>

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

					<b>@lang('main.best_describes')</b>

					<div class="imagespain">
						<img src="img/paingrafic.png" alt="" class="leftimg"><p>@lang('main.pain_with_slight')<input type="radio" name="imaga" id="" value="1" onchange="quesimg()"></p>
					</div> <br><br><br>
					<div class="imagespain1">
						<img src="img/paingrafic1.png" alt="" class="leftimg"><p>@lang('main.pain_with_pain')<input type="radio" name="imaga" id="" value="2" onchange="quesimg()"></p>
					</div><br><br><br>
					<div class="imagespain2">
						<img src="img/paingrafic2.png" alt="" class="leftimg"><p>@lang('main.pain_between_them') <input type="radio" name="imaga" id="" value="3"
								onchange="quesimg()"></p>
					</div><br><br>
					<div class="imagespain2">
						<img src="img/paingrafic3.png" alt="" class="leftimg"><p>@lang('main.attacks_with_pain') <input type="radio" name="imaga" id=""
								value="4" onchange="quesimg()"></p>
					</div><br><br>

				</div>

			</div>


			<div class="mans">
				<p>@lang('main.area_of_pain')
				</p>

                <canvas
                    id="replacement"
                    width="450"
                    height="400"
                ></canvas>

                <p>@lang('main.radiate_to_other')</p>
				<button class="button1" type="button" onclick="qustionmans()">@lang('main.yes')</button>
				<button class="button2" type="button" onclick="qustionmans()">@lang('main.no')</button>
			</div>

		</div>
		<div class="resalt">
			<div class="severityend">
				<b>@lang('main.suffer_from')</b>
				<br>

				<ul class="lis">
					<li>
						<p>@lang('main.never')<input type="radio" name="questions4" id="" onchange="questions4()" value="0"></p>
					</li>
					<li>
						<p>@lang('main.hardly_noticed')<input type="radio" name="questions4" id="" onchange="questions4()" value="1"></p>
					</li>
					<li>
						<p>@lang('main.slightly')<input type="radio" name="questions4" id="" onchange="questions4()" value="2"></p>
					</li>
					<li>
						<p>@lang('main.moderately')<input type="radio" name="questions4" id="" onchange="questions4()" value="3"></p>
					</li>
					<li>
						<p>@lang('main.strongly')<input type="radio" name="questions4" id="" onchange="questions4()" value="4"></p>
					</li>
					<li>
						<p>@lang('main.very_strongly')<input type="radio" name="questions4" id="" onchange="questions4()" value="5"></p>
					</li>


				</ul>
				<br>

				<b>@lang('main.tingling_or_prickling')</b>
				<br>


				<ul class="lis">
					<li>
						<p>@lang('main.never')<input type="radio" name="questions5" id="" onchange="questions5()" value="0"></p>
					</li>
					<li>
						<p>@lang('main.hardly_noticed')<input type="radio" name="questions5" id="" onchange="questions5()" value="1"></p>
					</li>
					<li>
						<p>@lang('main.slightly')<input type="radio" name="questions5" id="" onchange="questions5()" value="2"></p>
					</li>
					<li>
						<p>@lang('main.moderately')<input type="radio" name="questions5" id="" onchange="questions5()" value="3"></p>
					</li>
					<li>
						<p>@lang('main.strongly')<input type="radio" name="questions5" id="" onchange="questions5()" value="4"></p>
					</li>
					<li>
						<p>@lang('main.very_strongly')<input type="radio" name="questions5" id="" onchange="questions5()" value="5"></p>
					</li>
				</ul>
				<br>
				<b>@lang('main.clothing_a_blanket')</b>
				<br>

				<ul class="lis">
					<li>
						<p>@lang('main.never')<input type="radio" name="questions6" id="" onchange="questions6()" value="0"></p>
					</li>
					<li>
						<p>@lang('main.hardly_noticed')<input type="radio" name="questions6" id="" onchange="questions6()" value="1"></p>
					</li>
					<li>
						<p>@lang('main.slightly')<input type="radio" name="questions6" id="" onchange="questions6()" value="2"></p>
					</li>
					<li>
						<p>@lang('main.moderately')<input type="radio" name="questions6" id="" onchange="questions6()" value="3"></p>
					</li>
					<li>
						<p>@lang('main.strongly')<input type="radio" name="questions6" id="" onchange="questions6()" value="4"></p>
					</li>
					<li>
						<p>@lang('main.very_strongly')<input type="radio" name="questions6" id="" onchange="questions6()" value="5"></p>
					</li>
				</ul>
				<br>
				<b>@lang('main.sudden_pain_attacks')</b>
				<br>

				<ul class="lis">
					<li>
						<p>@lang('main.never')<input type="radio" name="questions7" id="" onchange="questions7()" value="0"></p>
					</li>
					<li>
						<p>@lang('main.hardly_noticed')<input type="radio" name="questions7" id="" onchange="questions7()" value="1"></p>
					</li>
					<li>
						<p>@lang('main.slightly')<input type="radio" name="questions7" id="" onchange="questions7()" value="2"></p>
					</li>
					<li>
						<p>@lang('main.moderately')<input type="radio" name="questions7" id="" onchange="questions7()" value="3"></p>
					</li>
					<li>
						<p>@lang('main.strongly')<input type="radio" name="questions7" id="" onchange="questions7()" value="4"></p>
					</li>
					<li>
						<p>@lang('main.very_strongly')<input type="radio" name="questions7" id="" onchange="questions7()" value="5"></p>
					</li>

				</ul>
				<br>

				<b>@lang('main.bath_water')</b>
				<br>


				<ul class="lis">
					<li>
						<p>@lang('main.never')<input type="radio" name="questions8" id="" onchange="questions8()" value="0"></p>
					</li>
					<li>
						<p>@lang('main.hardly_noticed')<input type="radio" name="questions8" id="" onchange="questions8()" value="1"></p>
					</li>
					<li>
						<p>@lang('main.slightly')<input type="radio" name="questions8" id="" onchange="questions8()" value="2"></p>
					</li>
					<li>
						<p>@lang('main.moderately')<input type="radio" name="questions8" id="" onchange="questions8()" value="3"></p>
					</li>
					<li>
						<p>@lang('main.strongly')<input type="radio" name="questions8" id="" onchange="questions8()" value="4"></p>
					</li>
					<li>
						<p>@lang('main.very_strongly')<input type="radio" name="questions8" id="" onchange="questions8()" value="5"></p>
					</li>
				</ul>
				<br>
				<b> @lang('main.from_a_sensation')</b>
				<br>

				<ul class="lis">
					<li>
						<p>@lang('main.never')<input type="radio" name="questions9" id="" onchange="questions9()" value="0"></p>
					</li>
					<li>
						<p>@lang('main.hardly_noticed')<input type="radio" name="questions9" id="" onchange="questions9()" value="1"></p>
					</li>
					<li>
						<p>@lang('main.slightly')<input type="radio" name="questions9" id="" onchange="questions9()" value="2"></p>
					</li>
					<li>
						<p>@lang('main.moderately')<input type="radio" name="questions9" id="" onchange="questions9()" value="3"></p>
					</li>
					<li>
						<p>@lang('main.strongly')<input type="radio" name="questions9" id="" onchange="questions9()" value="4"></p>
					</li>
					<li>
						<p>@lang('main.very_strongly')<input type="radio" name="questions9" id="" onchange="questions9()" value="5"></p>
					</li>
				</ul>
				<br>

				<b> @lang('main.with_a-finger')</b>
				<br>
				<ul class="lis">
					<li>
						<p>@lang('main.never')<input type="radio" name="questions10" id="" onchange="questions10()" value="0"></p>
					</li>
					<li>
						<p>@lang('main.hardly_noticed')<input type="radio" name="questions10" id="" onchange="questions10()" value="1"></p>
					</li>
					<li>
						<p>@lang('main.slightly')<input type="radio" name="questions10" id="" onchange="questions10()" value="2"></p>
					</li>
					<li>
						<p>@lang('main.moderately')<input type="radio" name="questions10" id="" onchange="questions10()" value="3"></p>
					</li>
					<li>
						<p>@lang('main.strongly')<input type="radio" name="questions10" id="" onchange="questions10()" value="4"></p>
					</li>
					<li>
						<p>@lang('main.very_strongly')<input type="radio" name="questions10" id="" onchange="questions10()" value="5"></p>
					</li>
				</ul>
				<br>
				<br>
				<div class="culculate">
					<span><textarea name="result" cols="80" rows="5" id="myText" >0</textarea></span>
					<button class="button1" onclick="resalt(summa ())">@lang('main.send_the_result')</button>
				</div>
			</div>
            </div>
	</form>
	<script type="text/javascript" src="js/script.js"></script>
</body>

</html>
