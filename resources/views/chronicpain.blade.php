<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{route('paindetect')}}" method="post">
        @csrf
        <h2>Опитувальник DN4 нейропатичного болю</h2>
        <h4>Чи відповідає біль, яку ви відчуваєте, одному або декільком з наступних визначень?</h4>
        <p>1. Відчуття печіння *</p>
        <label>так<input type="radio" name="question" value="true"></label>
        <label>ні<input type="radio" name="question" value="false"></label>
        <p>2. Болісне відчуття холоду *</p>
       <label>так<input type="radio" name="question_1" value="true"></label>
       <label>ні<input type="radio" name="question_1" value="false"></label>
       <p>3. Відчуття як від удару струмом **</p>
       <label>так<input type="radio" name="question_2" value="true"></label>
       <label>ні<input type="radio" name="question_2" value="false"></label>
       <h4>Чи супроводжується біль одним або декількома з наступних симптомів в області її локалізації?</h4>
       <p>4. Пощипуванням, відчуттям повзання мурашок *</p>
       <label>так<input type="radio" name="question_3" value="true"></label>
       <label>ні<input type="radio" name="question_3" value="false"></label>
       <p>5. Поколюванням *</p>
       <label>так<input type="radio" name="question_4" value="true"></label>
       <label>ні<input type="radio" name="question_4" value="false"></label>
       <p>6. Онімінням *</p>
       <label>так<input type="radio" name="question_5" value="true"></label>
       <label>ні<input type="radio" name="question_5" value="false"></label>
       <p>7. Свербінням *</p>
       <label>так<input type="radio" name="question_6" value="true"></label>
       <label>ні<input type="radio" name="question_6" value="false"></label>
       <h4>Чи локалізован біль в тій же області, де один або обидва наступних симптоми:</h4>
       <p>8. Знижена чутливість до дотиків **</p>
       <label>так<input type="radio" name="question_7" value="true"></label>
       <label>ні<input type="radio" name="question_7" value="false"></label>
       <p>9. Знижена чутливість до поколювань *</p>
       <label>так<input type="radio" name="question_8" value="true"></label>
       <label>ні<input type="radio" name="question_8" value="false"></label>
       <p>10. Можете викликати або посилити біль, якщо провести пензликом? *</p>
       <label>так<input type="radio" name="question_9" value="true"></label>
       <label>ні<input type="radio" name="question_9" value="false"></label><br><br>
      <input type="submit" value="Надіслати результат">
    </form>

</body>
</html>
