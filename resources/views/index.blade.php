<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PainMehanism</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
	<header>
		<div class="logo">
			<a href="index.html"><img class="graficlogo" src="img/logotip1.png" alt="logotip" width="120px"
					height="120"></a>
		</div>
	</header>



		<main>
            <form action="{{route('index')}}" method="POST">
            @csrf
			<div class="date2">
			<div class="date1">Дата</div>
			<input type="date" name="date" id="userdate">
			<div class="date1">Пацыент</div>
			<input type="text" name="name" id="user" value=""
				placeholder="Ф.И.О._ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _">
			<input type="text" name="id_patient" id="username" value=""
				placeholder="ID-пациента_ _ _ _ _ _ _ _ _">
			<input type="text" name="contact_id" id="username" value=""
				placeholder="Как с вами связаться_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _">
		</div>

			<div class="mainontent">
				<div class="notioncicep">
					<h4>Ноцицепция</h4>
					<p>Повреждение</p>

					<ul class="lis">
						<li>да<input type="radio" name="questions1" id="" value="true"></li>
						<li>
							<p>нет<input type="radio" name="questions1" id="" value="false"></p>
						</li>

					</ul>

					<p>Лабораторные признаки воспаления или диагностировано воспалительное заболевание.</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions2" id="" value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions2" id="" value="false"></p>
						</li>

					</ul>

					<p>Отеки</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions3" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions3" id="" value="false"></p>
						</li>

					</ul>

					<p>Локальное повышение температуры</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions4" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions4" id="" value="false"></p>
						</li>

					</ul>

					<p>Покраснение</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions5" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions5" id="" value="false"></p>
						</li>

					</ul>
					<p>Движение усиливают боль</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions6" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions6" id=""value="false"></p>
						</li>

					</ul>

					<p>Мышечный спазм</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions7" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions7" id=""value="false"></p>
						</li>

					</ul>


				</div>



				<div class="ishemia">
					<h4>Ишемическая боль</h4>

					<p>«Перемежающаяся храмота»</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions8" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions8" id="" value="false"></p>
						</li>

					</ul>

					<p>
						Отечность нижних конечностей;

						(тяжесть и усталость в ногах в конце дня или после ходьбы)</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions9" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions9" id="" value="false"></p>
						</li>

					</ul>

					<p>Похолодание конечностей</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions10" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions10" id="" value="false"></p>
						</li>

					</ul>

					<p>Ночные судороги икроножных мышц;</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions11" id="" value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions11" id="" value="false"></p>
						</li>

					</ul>

					<p>Трофические расстройства в виде атрезий, атрофии мышц ступни и голени, выпадение волос, дистрофии
						и нарушения роста ногтей,потемнение и некроз тканей пальцев стопы; (Язвы, которые долго не
						заживают, сухая, влажная гангрена.) </p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions12" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions12" id="" value="false"></p>
						</li>

					</ul>
					<p>Движение усиливают боль</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions13" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions13" id="" value="false"></p>
						</li>

					</ul>

					<p>Появление подкожной сосудистой сетки, выступающие вены на ногах</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions14" id="" value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions14" id="" value="false"></p>
						</li>

					</ul>

				</div>



				<div class="neyropatic">
					<h4>Нейропатическая боль</h4>
					<p>Жгучий, стреляющий, колющие</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions15" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions15" id="" value="false"></p>
						</li>

					</ul>

					<p>Усилеваеться в состоянии покоя, ночью</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions16" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions16" id="" value="false"></p>
						</li>

					</ul>

					<p>Аллодиния</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions17" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions17" id="" value="false"></p>
						</li>

					</ul>

					<p>Первичная гипералгезия</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions18" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions18" id="" value="false"></p>
						</li>

					</ul>

					<p>Удар «током»</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions19" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions19" id="" value="false"></p>
						</li>

					</ul>
					<p>Парестезии/дизестезии</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions20" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions20" id="" value="false"></p>
						</li>

					</ul>

					<p>Неефективность НПВС</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions21" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions21" id="" value="false"></p>
						</li>

					</ul>


				</div>


				<div class="sensetisetion">
					<h4>Центральная Сенситизация</h4>
					<p>Длительность >3-6 мес</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions22" id="" value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions22" id="" value="false"></p>
						</li>

					</ul>

					<p>Спонтанная боль </p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions23" id="" value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions23" id="" value="false"></p>
						</li>

					</ul>

					<p>Вторичная гипералгезия</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions24" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions24" id="" value="false"></p>
						</li>

					</ul>

					<p>Феномен Wind-up</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions25" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions25" id="" value="false"></p>
						</li>

					</ul>

					<p>Снижение порога БЧ у «неболевой» зоні</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions26" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions26" id="" value="false"></p>
						</li>

					</ul>
					<p>Неефективность НПВС</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions27" id=""  value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions27" id="" value="false"></p>
						</li>

					</ul>

				</div>


			</div>




			<div class="maincontriner2">
				<div class="desingibition">
					<h4>Дезингибиция антиноцицептивной системы</h4>
					<div>
						<p>Тривалість >3 міс- >1року</p>


						<ul class="lis">
							<li>
								<p>да<input type="radio" name="questions28" id="" value="true"></p>
							</li>
							<li>
								<p>нет<input type="radio" name="questions28" id="" value="false"></p>
							</li>

						</ul>

					</div>

					<div>
						<p>Генералізовані болі (постійне зростання кількості больових зон)</p>

						<ul class="lis">
							<li>
								<p>да<input type="radio" name="questions29" id=""  value="true"></p>
							</li>
							<li>
								<p>нет<input type="radio" name="questions29" id="" value="false"></p>
							</li>

						</ul>

					</div>


					<div class="conteiner">
						<div class="bigcriteriy">
							<p>Депресия (большие критерии)</p>
						</div>

						<div class="bigcriteriycon">
							<ul>
								<li>
									<p>Плохое настроение(«я никто…я ничто»)<input type="checkbox" name="questions30"
											id=""value="true"></p>
								</li>
								<li>
									<p>Потеря интересов/удовлетворения(«все плохо…»)і<input type="checkbox"
											name="questions31" id="" value="true"></p>
								</li>
								<li>
									<p>Снижение енергичности (астения, слабость) умственное и физическое истощение<input
											type="checkbox" name="questions30" id="" value="true"></p>
								</li>
							</ul>

						</div>

					</div>

					<div class="conteinertw">
						<div class="bigcriteriy1">
							<p>Замаскированая(Соматизированая депресия)</p>
						</div>

						<div class="bigcriteriycon1">
							<ul>
								<li>
									<p>Хронические боли при отсутствии объективных признаков поражения органов <input
											type="checkbox" name="questions32" id="" value="true"></p>
								</li>
								<li>
									<p>Росстройства апетита, набор/снижение масы<input type="checkbox" name="questions33"
											id="" value="true"></p>
								</li>
								<li>
									<p>Суточная ритмичность з улучшением на вечер/ сезонность <input type="checkbox"
											name="questions34" id="" value="true"></p>
								</li>
								<li>
									<p>Росстройство половой ф-ции(либидо)<input type="checkbox" name="questions35" id=""
                                        value="true"></p>
								</li>
								<li>
									<p>Росстройство сна<input type="checkbox" name="questions36" id="" value="true"></p>
								</li>
								<li>
									<p>Снижение концентрации внимания, астения.<input type="checkbox" name="questions37"
											id=""value="true"></p>
								</li>
							</ul>

						</div>

					</div>

					<div class="conteinerfiv">
						<div class="bigcriteriy2">
							<p>Тривога </p>
						</div>

						<div class="bigcriteriycon2">
							<ul>
								<li>
									<p>Удушье<input type="checkbox" name="questions38" id="" value="true"></p>
								</li>
								<li>
									<p>«Ком» в горле<input type="checkbox" name="questions39" id="" value="true"></p>
								</li>
								<li>
									<p>Тремор ,мышечное напряжение<input type="checkbox" name="questions40" id=""
                                        value="true"></p>
								</li>
								<li>
									<p>Бессонница<input type="checkbox" name="questions41" id="" value="true"></p>
								</li>
								<li>
									<p>Потливость, приливы жару <input type="checkbox" name="questions42" id=""
                                        value="true"></p>
								</li>
								<li>
									<p>Серцебиение<input type="checkbox" name="questions43" id="" value="true"></p>
								</li>
							</ul>

						</div>

					</div>

					<p>Неефективность НПВС</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions44" id="" value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions44" id="" value="false"></p>
						</li>

					</ul>




				</div>

				<div class="disfunction">
					<h4>Дисфункциональные боли</h4>
					<p>Отсутствие четко локализованого болю Непонятное и не четкое описание болевого синдрома
						Генерализованые боли (постоянное звозростание количества болевых зон).</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions46" id=""value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions46" id="" value="false"></p>
						</li>

					</ul>

					<p>Больной жалуеться на численные разнообразные соматические нарушения , которые не могут быть
						подтверждены реальними соматическими заболеваниями.</p>

					<ul class="lis">
						<li>
							<p>да<input type="radio" name="questions47" id="" value="true"></p>
						</li>
						<li>
							<p>нет<input type="radio" name="questions47" id="" value="false"></p>
						</li>

					</ul>

					<p>Коморбидность з дисфункциональными заболеваниями :</p>
					<ul>
						<li>
							<p>- Хроническая головная боль напряжения <input type="checkbox" name="questions48" id=""
                                value="true"></p>
						</li>
						<li>
							<p>- Соматоформное болеовое расстройство ( психогенная боль) <input type="checkbox"
									name="questions1" id="" value="true"></p>
						</li>
						<li>
							<p>- Синдром роздраженного кишечника<input type="checkbox" name="questions49" id=""
                                value="true"></p>
						</li>
						<li>
							<p>- Фибромиалгия <input type="checkbox" name="questions50" id="" value="true"></p>
						</li>
						<li>
							<p>- Інтерстициальный цыстит <input type="checkbox" name="questions51" id="" value="true"></p>
						</li>
						<li>
							<p>- Хроническая тазовая боль<input type="checkbox" name="questions52" id="" value="true"></p>
						</li>
						<li>
							<p>- Синдром неспокойных ног <input type="checkbox" name="questions53" id="" value="true"></p>
						</li>
						<li>
							<p>- Синдром хронической усталости<input type="checkbox" name="questions54" id="" value="true">
							</p>
						</li>
					</ul>
					<br>
					<br>
                     <strong><p>Проведенное лечение</p></strong>
                      <textarea name="treatment" id="" cols="92" rows="10"> </textarea>
                      <input type="submit" >
				</div>


			</div>


        </form>
		</main>


	<footer>

	</footer>




	<script src="JS/script.js"></script>
</body>

</html>
