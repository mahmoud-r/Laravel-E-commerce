@include('admin.lauout.import.head')


@section('title')Login @endsection

<style>
    /* /////// Sahar Ali Raza //////////// */

    /*//////////////////////////////////////////////////////////////////
    [ FONT ]*/

    @import url('https://fonts.googleapis.com/css?family=Montserrat:700');
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,700');



    /*//////////////////////////////////////////////////////////////////
    [ RESTYLE TAG ]*/

    * {
        margin: 0px;
        padding: 0px;
        box-sizing: border-box;
    }

    body, html {
        height: 100%;
        font-family: Poppins-Regular, sans-serif;
    }

    /*---------------------------------------------*/
    a {
        font-family: Poppins-Regular;
        font-size: 14px;
        line-height: 1.7;
        color: #333333;
        margin: 0px;
        transition: all 0.4s;
        -webkit-transition: all 0.4s;
        -o-transition: all 0.4s;
        -moz-transition: all 0.4s;
    }

    a:focus {
        outline: none !important;
    }

    a:hover {
        text-decoration: none;
        color: #1a73e8; /* أزرق غامق */
    }

    /*---------------------------------------------*/
    h1,h2,h3,h4,h5,h6 {
        margin: 0px;
    }

    p {
        font-family: Poppins-Regular;
        font-size: 14px;
        line-height: 1.7;
        color: #333333;
        margin: 0px;
    }

    ul, li {
        margin: 0px;
        list-style-type: none;
    }


    /*---------------------------------------------*/
    input {
        outline: none;
        border: none;
    }

    textarea {
        outline: none;
        border: none;
    }

    textarea:focus, input:focus {
        border-color: transparent !important;
    }

    input:focus::-webkit-input-placeholder { color:transparent; }
    input:focus:-moz-placeholder { color:transparent; }
    input:focus::-moz-placeholder { color:transparent; }
    input:focus:-ms-input-placeholder { color:transparent; }

    textarea:focus::-webkit-input-placeholder { color:transparent; }
    textarea:focus:-moz-placeholder { color:transparent; }
    textarea:focus::-moz-placeholder { color:transparent; }
    textarea:focus:-ms-input-placeholder { color:transparent; }

    input::-webkit-input-placeholder { color: #999999; }
    input:-moz-placeholder { color: #999999; }
    input::-moz-placeholder { color: #999999; }
    input:-ms-input-placeholder { color: #999999; }

    textarea::-webkit-input-placeholder { color: #999999; }
    textarea:-moz-placeholder { color: #999999; }
    textarea::-moz-placeholder { color: #999999; }
    textarea:-ms-input-placeholder { color: #999999; }

    /*---------------------------------------------*/
    button {
        outline: none !important;
        border: none;
        background: transparent;
    }

    button:hover {
        cursor: pointer;
    }

    iframe {
        border: none !important;
    }


    /*//////////////////////////////////////////////////////////////////
    [ Utility ]*/
    .txt1 {
        font-family: Poppins-Regular;
        font-size: 13px;
        line-height: 1.5;
        color: #999999;
    }

    .txt2 {
        font-family: Poppins-Regular;
        font-size: 13px;
        line-height: 1.5;
        color: #333333;
    }


    /*//////////////////////////////////////////////////////////////////
    [ login ]*/

    .limiter {
        width: 100%;
        margin: 0 auto;
    }

    .container-login100 {
        width: 100%;
        min-height: 100vh;
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        padding: 15px;
        background: #1a73e8; /* أزرق غامق */
        background: -webkit-linear-gradient(-135deg, #1a73e8, #0c47a1); /* أزرق غامق */
        background: -o-linear-gradient(-135deg, #1a73e8, #0c47a1); /* أزرق غامق */
        background: -moz-linear-gradient(-135deg, #1a73e8, #0c47a1); /* أزرق غامق */
        background: linear-gradient(-135deg, #1a73e8, #0c47a1); /* أزرق غامق */
    }

    .wrap-login100 {
        width: 960px;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;

        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 177px 130px 33px 95px;
    }

    /*------------------------------------------------------------------
    [  ]*/
    .login100-pic {
        width: 316px;
    }

    .login100-pic img {
        max-width: 100%;
    }


    /*------------------------------------------------------------------
    [  ]*/
    .login100-form {
        width: 290px;
    }

    .login100-form-title {
        font-family: Poppins-Bold;
        font-size: 24px;
        color: #333333;
        line-height: 1.2;
        text-align: center;

        width: 100%;
        display: block;
        padding-bottom: 54px;
    }


    /*---------------------------------------------*/
    .wrap-input100 {
        position: relative;
        width: 100%;
        z-index: 1;
        margin-bottom: 10px;
    }

    .input100 {
        font-family: Poppins-Medium;
        font-size: 15px;
        line-height: 1.5;
        color: #333333;

        display: block;
        width: 100%;
        background: #e6e6e6;
        height: 50px;
        border-radius: 25px;
        padding: 0 30px 0 68px;
    }


    /*------------------------------------------------------------------
    [ Focus ]*/
    .focus-input100 {
        display: block;
        position: absolute;
        border-radius: 25px;
        bottom: 0;
        left: 0;
        z-index: -1;
        width: 100%;
        height: 100%;
        box-shadow: 0px 0px 0px 0px;
        color: #1a73e8;
    }

    .input100:focus + .focus-input100 {
        -webkit-animation: anim-shadow 0.5s ease-in-out forwards;
        animation: anim-shadow 0.5s ease-in-out forwards;
    }

    @-webkit-keyframes anim-shadow {
        to {
            box-shadow: 0px 0px 70px 25px #1a73e8; /* أزرق غامق */
            opacity: 0;
        }
    }

    @keyframes anim-shadow {
        to {
            box-shadow: 0px 0px 70px 25px #1a73e8; /* أزرق غامق */
            opacity: 0;
        }
    }

    .symbol-input100 {
        font-size: 15px;

        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        align-items: center;
        position: absolute;
        border-radius: 25px;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        padding-left: 35px;
        pointer-events: none;
        color: #333333;

        -webkit-transition: all 0.4s;
        -o-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
    }

    .input100:focus + .focus-input100 + .symbol-input100 {
        color: #1a73e8; /* أزرق غامق */
        padding-left: 28px;
    }

    /*------------------------------------------------------------------
    [ Button ]*/
    .container-login100-form-btn {
        width: 100%;
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding-top: 20px;
    }

    .login100-form-btn {
        font-family: Montserrat-Bold;
        font-size: 15px;
        line-height: 1.5;
        color: #fff;
        text-transform: uppercase;

        width: 100%;
        height: 50px;
        border-radius: 25px;
        background: #1a73e8; /* أزرق غامق */
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0 25px;

        -webkit-transition: all 0.4s;
        -o-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
    }

    .login100-form-btn:hover {
        background: #0c47a1; /* أزرق أغمق */
    }



    /*------------------------------------------------------------------
    [ Responsive ]*/



    @media (max-width: 992px) {
        .wrap-login100 {
            padding: 177px 90px 33px 85px;
        }

        .login100-pic {
            width: 35%;
        }

        .login100-form {
            width: 50%;
        }
    }

    @media (max-width: 768px) {
        .wrap-login100 {
            padding: 100px 80px 33px 80px;
        }

        .login100-pic {
            margin: auto;
        }

        .login100-form {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .wrap-login100 {
            padding: 100px 15px 33px 15px;
        }
    }
    .p-t-136 {
        padding-top: 80px;
    }
    .p-t-12 {padding-top: 12px;}
    /* ------------------------------------ */
    .text-center {text-align: center;}
    .text-left {text-align: left;}
    .text-right {text-align: right;}
    .text-middle {vertical-align: middle;}
    /*------------------------------------------------------------------
    [ Alert validate ]*/

    .validate-input {
        position: relative;
    }

    .alert-validate::before {
        content: attr(data-validate);
        position: absolute;
        max-width: 70%;
        background-color: white;
        border: 1px solid #c80000;
        border-radius: 13px;
        padding: 4px 25px 4px 10px;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        -o-transform: translateY(-50%);
        transform: translateY(-50%);
        right: 8px;
        pointer-events: none;

        font-family: Poppins-Medium;
        color: #c80000;
        font-size: 13px;
        line-height: 1.4;
        text-align: left;

        visibility: hidden;
        opacity: 0;

        -webkit-transition: opacity 0.4s;
        -o-transition: opacity 0.4s;
        -moz-transition: opacity 0.4s;
        transition: opacity 0.4s;
    }

    .alert-validate::after {
        content: "\f06a";
        font-family: FontAwesome;
        display: block;
        position: absolute;
        color: #c80000;
        font-size: 15px;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        -o-transform: translateY(-50%);
        transform: translateY(-50%);
        right: 13px;
    }

    .alert-validate:hover:before {
        visibility: visible;
        opacity: 1;
    }

    @media (max-width: 992px) {
        .alert-validate::before {
            visibility: visible;
            opacity: 1;
        }
    }

</style>

<body class="hold-transition login-page">
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt">
                <img src="https://2.bp.blogspot.com/-l9nGy2e3PnA/XLzG5A6u_cI/AAAAAAAAAgI/31bl8XZOrTwN0kTN8c18YOG3OhNiTUrsQCLcBGAs/s1600/rocket.png" alt="IMG">
            </div>

            <form class="login100-form validate-form" action="{{route('login.functionality')}}" method="post">
                @csrf
					<span class="login100-form-title">
						Member Login
					</span>

                <div class="wrap-input100 ">
                    <input type="email" class="input100   @error('email') is-invalid @enderror" name="email"
                           value="{{ old('email') ?old('email') :'Guest@shopwise.com' }}"
                           placeholder="Email">
                    <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                </div>
                @error('email')
                <p class="invalid-feedback">{{$message}}</p>
                @enderror

                <div class="wrap-input100 " >

                    <input type="password" class="input100  @error('password') is-invalid @enderror" name="password"
                           placeholder="Password"
                           value="Guest@shopwise.com1">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                </div>

                <div class="custom-control custom-switch mt-3 ml-2">
                    <input type="checkbox" class="custom-control-input" name="remember" id="remember" checked>
                    <label class="custom-control-label" for="remember"> Remember Me</label>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type="submit">
                        Login
                    </button>
                </div>

                <div class="text-center p-t-12">

                </div>

                <div class="text-center p-t-136">

                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.lauout.import.script')

</body>
</html>
