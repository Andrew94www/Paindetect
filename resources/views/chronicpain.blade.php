<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DN4</title>
    <style>
        /* добавляем стили для мобильных устройств */
        @media only screen and (max-width: 600px) {
            h2 { font-size: 1.5rem; }
            h4 { font-size: 1rem; }
            p { font-size: 0.8rem; }
            label { font-size: 0.8rem; }
        }
        input[type="submit"] {
            border: none;
            border-radius: 4px;
            background-color: #5479a2;
            color: white;
            padding: 12px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            transition-duration: 0.4s;
        }

        input[type="submit"]:hover {
            background-color: #fd082d;
        }

    </style>
</head>
<body>
    <form action="{{route('paindetect')}}" method="post">
        @csrf
        <h2>@lang('main.dn4')</h2>
        <h4>@lang('main.experience_correspond')</h4>
        <p>1. @lang('main.burning_sensation')</p>
        <label>@lang('main.yes')<input type="radio" name="question" id=""  onchange="queStions2('question')" value="1"></label>
        <label>@lang('main.no')<input type="radio" name="question" onchange="queStions2('question')" value="0"></label>
        <p>2. @lang('main.sensation_of_coldness')</p>
       <label>@lang('main.yes')<input type="radio" name="question_1"  onchange="queStions2('question_1')" value="1"></label>
       <label>@lang('main.no')<input type="radio" name="question_1" onchange="queStions2('question1_')" value="0"></label>
       <p>3. @lang('main.electric_shock')</p>
       <label>@lang('main.yes')<input type="radio" name="question_2" onchange="queStions2('question_2')" value="1"></label>
       <label>@lang('main.no')<input type="radio" name="question_2" onchange="queStions2('question_2')" value="0"></label>
       <h4>@lang('main.following_symptoms')</h4>
       <p>4. @lang('main.itching_sensation')</p>
       <label>@lang('main.yes')<input type="radio" name="question_3"  onchange="queStions2('question_3')" value="1"></label>
       <label>@lang('main.no')<input type="radio" name="question_3" onchange="queStions2('question_2')" value="0"></label>
       <p>5. @lang('main.pricking_sensation')</p>
       <label>@lang('main.yes')<input type="radio" name="question_4"  onchange="queStions2('question_4')" value="1"></label>
       <label>@lang('main.no')<input type="radio" name="question_4"  onchange="queStions2('question_4')" value="0"></label>
       <p>6. @lang('main.numbness')</p>
       <label>@lang('main.yes')<input type="radio" name="question_5"  onchange="queStions2('question_5')" value="1"></label>
       <label>@lang('main.no')<input type="radio" name="question_5"  onchange="queStions2('question_5')" value="0"></label>
       <p>7. @lang('main.itching')</p>
       <label>@lang('main.yes')<input type="radio" name="question_6"  onchange="queStions2('question_6')" value="1"></label>
       <label>@lang('main.no')<input type="radio" name="question_6"  onchange="queStions2('question_6')" value="0"></label>
       <h4>@lang('main.same_area')</h4>
       <p>8. @lang('main.diminished_sensitivity')</p>
       <label>@lang('main.yes')<input type="radio" name="question_7"  onchange="queStions2('question_7')" value="1"></label>
       <label>@lang('main.no')<input type="radio" name="question_7"  onchange="queStions2('question_7')" value="0"></label>
       <p>9.  @lang('main.sensitivity_to_pricking')</p>
       <label>@lang('main.yes')<input type="radio" name="question_8"  onchange="queStions2('question_8')" value="1"></label>
       <label>@lang('main.no')<input type="radio" name="question_8"  onchange="queStions2('question_8')" value="0"></label>
       <p>10.  @lang('main.with_a_brush')</p>
       <label>@lang('main.yes')<input type="radio" name="question_9" onchange="queStions2('question_9')" value="1"></label>
       <label>@lang('main.no')<input type="radio" name="question_9"  onchange="queStions2('question_2')" value="0"></label><br><br>
        <input type="hidden" name="chronicPain" value="" id="chronicPain">
      <input type="submit" value="@lang('main.send_the_result')" onclick="resultChronicPain()">
    </form>
    <script type="text/javascript" src="js/index.js"></script>
</body>
</html>
