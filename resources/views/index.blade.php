<!DOCTYPE html>
<html lang="en">
   {{App::setLocale(session('locale'))}}
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PainMehanism</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body link ="red" vlink="white">
    <header>
        <div class="container">
          <div class="headerContent">
            <h1>Pain Mechanism</h1>
              <img src="img/detect.png" alt="Описание изображения" width="100" height="100" class="header-image">
            <nav><a href="{{ route('locale', 'ua') }}" >UA</a><a href="{{ route('locale', 'ru') }}">RU</a><a href="{{ route('locale', 'en') }}">EN</a></nav>
        </div>
        </div>
      </header>
		<main>
            <form action="{{route('index')}}" method="POST">
            @csrf
			<div class="date2">
			<div class="date1">@lang('main.date')</div>
			<input type="date" name="date" id="userdate">
			<div class="date1">@lang('main.patient_a')</div>
			<input type="text" name="name" id="user" value=""
				placeholder="@lang('main.full_name')._ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _">
			<input type="text" name="id_patient" id="username" value=""
				placeholder="@lang('main.id_patient')_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _">
			<input type="text" name="contact_id" id="username" value=""
				placeholder="@lang('main.contact_you')_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _">
		</div>
			<div class="mainontent">
				<div class="notioncicep">
					<h4>@lang('main.nociception')</h4>
					<p>@lang('main.damage')</p>

					<ul class="lis">
						<li>@lang('main.yes')<input type="radio" name="questions1" id=""  value="14" onchange="queStions1('questions1')"></li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions1" id="" value="0" onchange="queStions1('questions1')"></p>
						</li>

					</ul>

					<p>@lang('main.inflammation')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions2" id="" value="14" onchange="queStions1('questions2')"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions2" id="" value="0" onchange="queStions1('questions2')"></p>
						</li>

					</ul>

					<p>@lang('main.edema')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions3" id="" onchange="queStions1('questions3')" value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions3" id="" onchange="queStions1('questions3')" value="0"></p>
						</li>

					</ul>

					<p>@lang('main.temperature')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions4" id=""  onchange="queStions1('questions4')" value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions4" id=""   onchange="queStions1('questions4')" value="0"></p>
						</li>

					</ul>

					<p>@lang('main.red')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions5" id="" onchange="queStions1('questions5')" value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions5" id="" onchange="queStions1('questions5')" value="0"></p>
						</li>

					</ul>
					<p>@lang('main.pain')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions6" id=""  onchange="queStions1('questions6')" value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions6" id="" onchange="queStions1('questions6')" value="0"></p>
						</li>

					</ul>

					<p>@lang('main.spasm')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions7" id="" onchange="queStions1('questions7')" value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions7" id="" onchange="queStions1('questions7')" value="0"></p>
						</li>

					</ul>


				</div>



				<div class="ishemia">
					<h4>@lang('main.ischemic_pain')</h4>

					<p data-toggle="tooltip" data-placement="top"  title="@lang('main.per_chram')">@lang('main.ntermittent_claudication')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions8" id="" onchange="queStions1('questions8')" value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions8" id="" onchange="queStions1('questions8')"  value="0"></p>
						</li>

					</ul>

					<p>
                        @lang('main.lower_limbs_edema')

						</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions9" id="" onchange="queStions1('questions9')"  value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions9" id=""  onchange="queStions1('questions9')"  value="0"></p>
						</li>

					</ul>

					<p> @lang('main.cold_extremities')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions10" id="" onchange="queStions1('questions10')"  value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions10" id="" onchange="queStions1('questions10')" value="0"></p>
						</li>

					</ul>

					<p>@lang('main.shin_muscles')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions11" id="" onchange="queStions1('questions11')"  value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions11" id=""  onchange="queStions1('questions11')" value="0"></p>
						</li>

					</ul>

					<p>@lang('main.trophic_disorders')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions12" id="" onchange="queStions1('questions12')"  value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions12" id="" onchange="queStions1('questions12')"  value="0"></p>
						</li>

					</ul>
					<p>@lang('main.provokes_pain')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions13" id="" onchange="queStions1('questions13')"   value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions13" id="" onchange="queStions1('questions13')"  value="0"></p>
						</li>

					</ul>

					<p>@lang('main.varicose_deformation')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions14" id="" onchange="queStions1('questions14')" value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions14" id=""  onchange="queStions1('questions14')" value="0"></p>
						</li>

					</ul>

				</div>



				<div class="neyropatic">
					<h4>@lang('main.neuropathic_pain')</h4>
					<p>@lang('main.shooting')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions15" id=""   onchange="queStions1('questions15')"  value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions15" id=""   onchange="queStions1('questions15')"  value="0"></p>
						</li>

					</ul>

					<p>@lang('main.rest_night')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions16" id=""  onchange="queStions1('questions16')"  value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions16" id=""   onchange="queStions1('questions16')" value="0"></p>
						</li>

					</ul>

					<p data-toggle="tooltip" data-placement="top"  title="@lang('main.allodenia_desc')">@lang('main.allodynia')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions17" id=""  onchange="queStions1('questions17')"  value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions17" id=""   onchange="queStions1('questions17')" value="0"></p>
						</li>

					</ul>

					<p  data-toggle="tooltip" data-placement="top"  title="@lang('main.hyperalgesia_one')">@lang('main.hyperalgesia')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions18" id="" onchange="queStions1('questions18')" value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions18" id="" onchange="queStions1('questions18')" value="0"></p>
						</li>

					</ul>

					<p>@lang('main.electric shock')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions19" id="" onchange="queStions1('questions19')" value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions19" id=""  onchange="queStions1('questions19')" value="0"></p>
						</li>

					</ul>
                    <p data-toggle="tooltip" data-placement="top"  title="@lang('main.dyastesia_desc')">@lang('main.dysesthesia')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions20" id="" onchange="queStions1('questions20')" value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions20" id="" onchange="queStions1('questions20')" value="0"></p>
						</li>

					</ul>

                    <p>@lang('main.effectiveness')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions21" id="" onchange="queStions1('questions21')" value="14"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions21" id=""  onchange="queStions1('questions21')" value="0"></p>
						</li>

					</ul>


				</div>


				<div class="sensetisetion">
					<h4>@lang('main.central_sensitization')</h4>
                    <p>@lang('main.duration')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions22" id="" onchange="queStions1('questions22')" value="15"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions22" id=""  onchange="queStions1('questions22')" value="0"></p>
						</li>

					</ul>

					<p> @lang('main.spontaneous') </p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions23" id=""  onchange="queStions1('questions23')" value="15"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions23" id=""   onchange="queStions1('questions23')" value="0"></p>
						</li>

					</ul>

					<p data-toggle="tooltip" data-placement="top"  title="@lang('main.hyperalgesia_two')">@lang('main.secondary_hyperalgesia')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions24" id=""  onchange="queStions1('questions24')" value="15"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions24" id=""   onchange="queStions1('questions24')" value="0"></p>
						</li>

					</ul>

					<p data-toggle="tooltip" data-placement="top"  title="@lang('main.wind-up')">@lang('main.phenomenon')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions25" id=""  onchange="queStions1('questions25')" value="15"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions25" id=""  onchange="queStions1('questions25')" value="0"></p>
						</li>

					</ul>

					<p>@lang('main.threshold')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions26" id=""  onchange="queStions1('questions26')" value="15"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions26" id=""  onchange="queStions1('questions26')" value="0"></p>
						</li>

					</ul>
                    <p>@lang('main.effectiveness')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions27" id=""  onchange="queStions1('questions27')" value="15"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions27" id=""  onchange="queStions1('questions27')" value="0"></p>
						</li>

					</ul>

				</div>


			</div>
			<div class="maincontriner2">
				<div class="desingibition">
					<h4>@lang('main.disinhibition')</h4>
					<div>
						<p>@lang('main.duration')</p>


						<ul class="lis">
							<li>
								<p>@lang('main.yes')<input type="radio" name="questions28" id=""   onchange="queStions1('questions28')" value="25"></p>
							</li>
							<li>
								<p>@lang('main.no')<input type="radio" name="questions28" id=""   onchange="queStions1('questions28')" value="0"></p>
							</li>

						</ul>

					</div>

					<div>
						<p>@lang('main.generalized')</p>

						<ul class="lis">
							<li>
								<p>@lang('main.yes')<input type="radio" name="questions29" id=""  onchange="queStions1('questions29')" value="25"></p>
							</li>
							<li>
								<p>@lang('main.no')<input type="radio" name="questions29" id=""  onchange="queStions1('questions29')" value="0"></p>
							</li>

						</ul>

					</div>


					<div class="conteiner">
						<div class="bigcriteriy">
							<p>@lang('main.major_criteria')</p>
						</div>

						<div class="bigcriteriycon">
							<ul>
								<li>
									<p>@lang('main.mood')<input type="checkbox" name="questions30"
											id=""  onchange="queStions1('questions30')" value="1"></p>
								</li>
								<li>
									<p>@lang('main.interests')<input type="checkbox"
											name="questions31" id="" onchange="queStions1('questions31')" value="1"></p>
								</li>
								<li>
									<p>@lang('main.decreased')<input
											type="checkbox" name="questions32" id="" onchange="queStions1('questions32')"value="1"></p>
								</li>
							</ul>

						</div>

					</div>

					<div class="conteinertw">
						<div class="bigcriteriy1">
							<p>@lang('main.masked')</p>
						</div>

						<div class="bigcriteriycon1">
							<ul>
								<li>
									<p>@lang('main.chronic_pain') <input
											type="checkbox" name="questions33" id="" onchange="queStions1('questions33')" value="1"></p>
								</li>
								<li>
									<p>@lang('main.reduction')<input type="checkbox" name="questions33"
											id=""  onchange="queStions1('questions33')" value="1"></p>
								</li>
								<li>
									<p>@lang('main.rhythm')<input type="checkbox"
											name="questions34" id=""  onchange="queStions1('questions34')" value="1"></p>
								</li>
								<li>
									<p>@lang('main.libido')<input type="checkbox" name="questions35" id=""
                                        onchange="queStions1('questions35')" value="1"></p>
								</li>
								<li>
									<p>@lang('main.sleep')<input type="checkbox" name="questions36" id=""  onchange="queStions1('questions36')" value="1"></p>
								</li>
								<li>
									<p>@lang('main.decreased').<input type="checkbox" name="questions37"
											id=""  onchange="queStions1('questions37')" value="1"></p>
								</li>
							</ul>

						</div>

					</div>

					<div class="conteinerfiv">
						<div class="bigcriteriy2">
							<p>@lang('main.disquiet') </p>
						</div>

						<div class="bigcriteriycon2">
							<ul>
								<li>
									<p>@lang('main.suffocation') <input type="checkbox" name="questions38" id=""  onchange="queStions1('questions38')" value="1"></p>
								</li>
								<li>
									<p>@lang('main.com')<input type="checkbox" name="questions39" id=""   onchange="queStions1('questions39')" value="1"></p>
								</li>
								<li>
									<p>@lang('main.tremor_m')<input type="checkbox" name="questions40" id=""
                                        onchange="queStions1('questions40')" value="1"></p>
								</li>
								<li>
									<p>@lang('main.Insomnia_a')<input type="checkbox" name="questions41" id=""  onchange="queStions1('questions41')" value="1"></p>
								</li>
								<li>
									<p>@lang('main.sweating')<input type="checkbox" name="questions42" id=""
                                        onchange="queStions1('questions42')"  value="1"></p>
								</li>
								<li>
									<p>@lang('main.heartbeat')<input type="checkbox" name="questions43" id=""  onchange="queStions1('questions43')" value="1"></p>
								</li>
							</ul>

						</div>

					</div>

					<p>@lang('main.effectiveness')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions44" id=""  onchange="queStions1('questions44')" value="25"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions44" id=""  onchange="queStions1('questions44')" value="0"></p>
						</li>

					</ul>




				</div>

				<div class="disfunction">
					<h4>@lang('main.dysfunctional_pain')</h4>
					<p>@lang('main.Absence')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions46" id="" onchange="queStions1('questions46')" value="25" ></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions46" id="" onchange="queStions1('questions46')" value="0"></p>
						</li>

					</ul>

					<p>@lang('main.patient_complains')</p>

					<ul class="lis">
						<li>
							<p>@lang('main.yes')<input type="radio" name="questions47" id="" onchange="queStions1('questions47')" value="25"></p>
						</li>
						<li>
							<p>@lang('main.no')<input type="radio" name="questions47" id="" onchange="queStions1('questions47')" value="0"></p>
						</li>

					</ul>

					<p>@lang('main.comorbidity')</p>
					<ul>
						<li>
							<p>@lang('main.tension_headache') <input type="checkbox" name="questions48" id=""
                                onchange="queStions1('questions48')" value="8"></p>
						</li>
						<li>
							<p>@lang('main.psychogenic_pain') <input type="checkbox"
									name="questions49" id=""  onchange="queStions1('questions49')" value="6"></p>
						</li>
						<li>
							<p data-toggle="tooltip" data-placement="top"  title="@lang('main.srk')"> @lang('main.irritable_bowel')<input type="checkbox" name="questions50" id=""
                                onchange="queStions1('questions50')" value="6"></p>
						</li>
						<li>
							<p data-toggle="tooltip" data-placement="top"  title="@lang('main.fibromialgia_desc')">@lang('main.fibromyalgia') <input type="checkbox" name="questions51" id=""  onchange="queStions1('questions51')" value="6"></p>
						</li>
						<li>
							<p data-toggle="tooltip" data-placement="top"  title="@lang('main.intercis')">@lang('main.interstitial_cystitis')  <input type="checkbox" name="questions52" id="" onchange="queStions1('questions52')" value="6"></p>
						</li>
						<li>
							<p>@lang('main.pelvic_pain') <input type="checkbox" name="questions53" id="" onchange="queStions1('questions53')" value="6"></p>
						</li>
						<li>
							<p data-toggle="tooltip" data-placement="top"  title="@lang('main.sbn')">@lang('main.leg_syndrome') <input type="checkbox" name="questions54" id="" onchange="queStions1('questions54')" value="6"></p>
						</li>
						<li>
							<p>@lang('main.chronic_fatigue_syndrome') <input type="checkbox" name="questions55" id="" onchange="queStions1('questions55')"  value="6">
							</p>
						</li>
                        <input type="hidden" name="nociceptionPain" value="" id="nociceptionPain">
                        <input type="hidden" name="ishemiaPain" value="" id="ishemiaPain">
                        <input type="hidden" name="neuropaticPain" value="" id="neuropaticPain">
                        <input type="hidden" name="sensitPain" value="" id="sensitPain">
                        <input type="hidden" name="dezingibitionPain" value="" id="dezingibitionPain">
                        <input type="hidden" name="disfunPain" value="" id="disfunPain">
					</ul>
					<br>
					<br>
                     <strong><p>@lang('main.treatmen_t')</p></strong>
                      <textarea name="treatment" id="" cols="92" rows="10"> </textarea>
                      <input type="submit" onclick="result()" value="{{ trans('main.send_the_result') }}" >
				</div>


			</div>
        </form>
		</main>
	<footer>
	</footer>
    <script type="text/javascript" src="js/index.js"></script>
    <!-- подключаем jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- подключаем плагин tooltip -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js" integrity="sha512-NHlD2xctgXoU6kYLvSBJpSzwVNRuoSQInuZWDVJhLbAzp7xUUJfg8j+HyAIlgmO1iqTJQr/jd8g+hYFeOwAPLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- подключаем CSS стили для tooltip -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tooltip.js/1.3.2/tooltip.min.css" integrity="sha512-FEl/XtMAkx+oeSSWJ9b31d2yJNEA37Ia+JaWpJ8MqecZuhN0Jxx5NlW5PhX3qPO5JhFtzWy/7GZfR8jsvQZX4Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</body>
</html>
