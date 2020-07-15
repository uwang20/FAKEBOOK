<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Facebook - Log In or Sign Up</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
    {{-- <link rel="stylesheet" href="{{assets('./css/header.css')}}"> --}}
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header{
            background-color: #3F5D9B;
            height: 13vh;
            padding-top: 10px;
            padding-bottom: 8px;
        }

        .logo h1{
            color: #fff;
        }

        .header-inner-container{
            width: 74%;
            height: 100%;
            margin: auto;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-inner-container form{
            display: flex;
        }

        form .form-group{
            margin-left: 20px;
        }

        form .form-group label{
            color: #fff;
            font-family: helvetica;
            font-size: 0.75rem;
            font-weight: 400;
        }

        .forgot-pw{
            font-size: 0.8rem;
            font-family: helvetica;
            text-decoration: none;
            color: rgba(255,255,255,0.5);
            margin-top: 2px;
        }

        form .form-group .input input{
            width: 150px;
            height: 1.3rem;
            outline: none;
            border: none;
            background-color: #E8F0FE;
            border-radius: 0;
            margin-top: 4px;
            margin-bottom: 4px;
            padding-left: 2px;
        }

        form .form-btn{
            align-self: center;
        }

        form .form-btn button{
            background-color: #4267b2;
            padding: 3px 6px;
            border: 1px solid #29487d;
            color: #fff;
            font-weight: 700;
            font-size: 0.8rem;
        }

        main{
            height: 87vh;
            background-color: #E9EBEE;

            display: flex;
        }

        .left-section{
            flex: 6;
        }

        .register-section{
            flex: 5;

        }

        .register-section .create-account{
            margin: 20px;
        }

        .register-section .create-account h1{
            font-family: helvetica;
            color: #333333;
            font-size: 2.4rem;
            margin-bottom: 5px;
        }

        .register-section .create-account h4{
            font-size: 1.2rem;
            font-family: sans-serif;
            font-weight: lighter;
            color: rgba(0,0,0,0.7);
        }

        .register-section .register-account form{
        }

        .register-section .register-account form .form-group, .form-gender-optional{
            margin-bottom: 10px;
            width: 420px;
        }

        .form-gender-optional{
            display: none;
            margin-top: 15px;
        }

        .register-section .register-account form .form-name{
            display: flex;
            justify-content: space-between;
        }

        .register-section .register-account form .form-name .input-container{
            position: relative;
        }

        .register-section .register-account form .form-group .input-container{
            position: relative;
        }

        .register-section .register-account form .form-gender .input-container{
            position: relative;
        }

        .input-container .invalid{
            position: absolute;
            background-color: #BE4B49;
            height: 25px;
            width: 25px;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            right: 0;
            margin-right: 10px;
            padding: 4px 2px;
        }

        .form-gender .input-container .invalid{
            position: absolute;
            background-color: #BE4B49;
            height: 25px;
            width: 25px;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%) translateX(310px);
            left: 0;
            margin-right: 10px;
            padding: 4px 2px;
        }

        .focus-warning{
            display: none;
        }

        .input-container .focus-warning{
            background-color: #BE4B49;
            position: absolute;
            left:0;
            top: 50%;
            transform: translateY(-50%) translateX(-120%);
            border-radius: 6px;
            border: none;

            font-family: sans-serif;
            color: #fff;
            padding: 15px;
            font-size: 0.9rem;
        }

        .last-name-container .focus-warning{
            background-color: #BE4B49;
            position: absolute;
            left:0;
            bottom: 0;
            transform: translateY(80%);
            border-radius: 6px;
            border: none;
            z-index: 5;

            font-family: sans-serif;
            color: #fff;
            padding: 15px;
            height: 45px;
            font-size: 0.9rem;
        }

        .arrow-to-right{
            position: absolute;
            top: 0;
            right: 0;
            transform: translateY(50%) translateX(80%);
        }

        .last-name-container .focus-warning .arrow-to-right{
            position: absolute;
            top: 7px;
            left: 10px;
            transform: translateY(-100%) rotateZ(-90deg);
        }

        .register-section .register-account form .form-birthday{
            margin-top: 25px;
        }

        .register-section .register-account form .form-birthday .date{
            display: flex;
        }

        .register-section .register-account form .form-birthday h1{
            font-family: sans-serif;
            font-size: 1rem;
            color: #90949C;
            margin-bottom: 10px;
        }

        .form-birthday select{
            padding: 5px 8px;
            border: 1px solid #ccd0d5;
            outline: none;
        }

        .register-section .register-account form .form-gender, .form-gender-optional{
            margin-left: 20px;
        }

        .register-section .register-account form .form-gender h1{
            font-family: sans-serif;
            font-size: 1rem;
            color: #90949C;
            margin-top: 12px;
            margin-bottom: 10px;
        }

        .form-gender .gender{
            display: flex;
        }

        .form-gender .gender label{
           display: flex;
           align-items: center;
           padding: 5px 6px;
           padding-right: 10px;
           margin-right: 16px;
           border-radius: 6px;
        }

        .form-gender .gender label h2{
            margin-left: 6px;
            font-size: 1.1rem;
            font-family: sans-serif;
            font-weight: normal;
        }

        .register-section .register-account form .lorem{
            margin-left: 20px;
            margin-top: 12px;
            width: 300px;
            line-height: 13px;
        }

        .register-section .register-account form .lorem p{
            font-size: 0.7rem;
            font-family: sans-serif;
            color: rgba(0,0,0,0.5);
        }

        .register-section .register-account form .form-group input, .form-gender-optional input{
            height: 2.3rem;
            width: 100%;
            border-radius: 6px;
            border: 1px solid #bdc7d8;
            padding-left: 10px;
            font-size: 1.2rem;
            outline: none;
        }

        .register-section .register-account form .form-group .invalid-red-border, .form-gender .gender .invalid-red-border{
            border: 1px solid red;
        }

        .register-section .register-account form .form-name input{
           width: 12.8rem;
        }

        .register-section .register-account form .form-button{
            margin-left: 20px;
            margin-top: 20px;
        }

        .register-section .register-account form .form-button button{
            padding: 7px 65px;
            font-size: 19px;
            background: linear-gradient(#67ae55, #578843);
            box-shadow: inset 0 1px 1px #a4e388;
            border:1px solid #3b6e22 #3b6e22 #2c5115;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            color: #fff;
        }

        .show-gender-optional{
            display: block;
        }
    </style>
    </head>
    <body>
        @include('auth.header.login')
        @include('auth.main.register')
        
        {{-- <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div> --}}
    </body>
<script>
    function getSelector(sel){
        return document.querySelector(sel);
    }
    function getSelectorAll(sel){
        return document.querySelectorAll(sel);
    }
    function makeElement(elem){
        return document.createElement(elem);
    }
    function addValue(value,elem){
        return elem.value = value;
    }
    function addText(text,parent){
        return parent.textContent = text;
    }
    function addChild(child,parent){
        return parent.appendChild(child);
    }

    var yearComboBox = getSelector("#year-selection");
    var dayComboBox = getSelector("#day-selection");
    var customGender = getSelector("#custom");
    var male = getSelector("#male");
    var female = getSelector("#female");
    var genderOptional = getSelector(".form-gender-optional");
    var genderOptionalInput = getSelector(".form-gender-optional input");
    var invalidButtons = getSelectorAll(".invalid");
    var genderBorders = getSelectorAll(".gender-border");
    var inputs = getSelectorAll(".input-container > input");
    var date = new Date();

    for(var i = date.getFullYear();i >= 1905;i--){
        var option = makeElement('option');
        addValue(i,option);
        addText(i,option);
        addChild(option,yearComboBox)
    }

    for(var i = 1;i <= 31;i++){
        var option = makeElement('option');
        addValue(i,option);
        addText(i,option);
        addChild(option,dayComboBox)
    }

    customGender.addEventListener('change',() => {
        genderOptional.classList.add('show-gender-optional')
    })

    male.addEventListener('change',() => {
        genderOptional.classList.remove('show-gender-optional')
    })

    female.addEventListener('change',() => {
        genderOptional.classList.remove('show-gender-optional')
    })

    invalidButtons.forEach(btn => {
        btn.addEventListener('click',(e) => {
            if(e.target.nodeName === 'svg'){
                if(e.target.parentNode.classList.contains('gender-invalid')){
                    invalidButtons.forEach(invalidBtn => {
                    invalidBtn.nextElementSibling.style.display = 'none'
                    invalidBtn.style.display = 'block'
                 })

                    inputs.forEach(input => {
                        input.classList.add('invalid-red-border')
                    })

                genderBorders.forEach(genderBorder => {
                    genderBorder.classList.remove('invalid-red-border')
                })

                e.target.parentNode.nextElementSibling.style.display = 'block'
                e.target.parentNode.style.display = 'none'
                return
                }

                invalidButtons.forEach(invalidBtn => {
                    invalidBtn.nextElementSibling.style.display = 'none'
                    invalidBtn.style.display = 'block'
                    invalidBtn.previousElementSibling.classList.add('invalid-red-border')
                 })

                 genderBorders.forEach(genderBorder => {
                    genderBorder.classList.add('invalid-red-border')
                })

                e.target.parentNode.nextElementSibling.style.display = 'block'
                e.target.parentNode.style.display = 'none'
                e.target.parentNode.previousElementSibling.focus()
                e.target.parentNode.previousElementSibling.classList.remove('invalid-red-border')
            }
            else{
                if(e.target.parentNode.parentNode.parentNode.parentNode.classList.contains('gender-invalid')){
                    invalidButtons.forEach(invalidBtn => {
                    invalidBtn.nextElementSibling.style.display = 'none'
                    invalidBtn.style.display = 'block'
                 })

                    inputs.forEach(input => {
                        input.classList.add('invalid-red-border')
                    })

                genderBorders.forEach(genderBorder => {
                    genderBorder.classList.remove('invalid-red-border')
                })

                e.target.parentNode.parentNode.parentNode.parentNode.nextElementSibling.style.display = 'block'
                e.target.parentNode.parentNode.parentNode.parentNode.style.display = 'none'
                return
                }

                invalidButtons.forEach(invalidBtn => {
                    invalidBtn.nextElementSibling.style.display = 'none'
                    invalidBtn.style.display = 'block'
                    invalidBtn.previousElementSibling.classList.add('invalid-red-border')
                 })

                 genderBorders.forEach(genderBorder => {
                    genderBorder.classList.add('invalid-red-border')
                })

                e.target.parentNode.parentNode.parentNode.parentNode.nextElementSibling.style.display = 'block'
                e.target.parentNode.parentNode.parentNode.parentNode.style.display = 'none'
                e.target.parentNode.parentNode.parentNode.parentNode.previousElementSibling.focus()
                e.target.parentNode.parentNode.parentNode.parentNode.previousElementSibling.classList.remove('invalid-red-border')
            }


        })
    })










    // if(customGender.hasAttribute('checked')){
    //     alert('hahahha')
    // }
</script>
</html>
