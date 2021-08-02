<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AMEN</title>
    <style>
        @media screen {
            body , html {
                margin : 0 ;
                height: 100% ;
            }
            a , body {
                font-family: Verdana ;
                font-size : 12px ;
            }
            .centeral {
                position: relative;
                height: 100%;
                flex: 1;
                display: flex;
                align-content: center;
                justify-content: center;
                flex-wrap: wrap;
                flex-direction: column
            }
            .shock {
                color: rgb(126, 126, 126) ;
                display: block ;
                position: relative;
                font-size : 80px ;
                letter-spacing: 10px;
                text-transform: uppercase;
            }
            .shock:after, .shock:before {
                position: absolute;
                background : #fff ;
                content: attr(data-label);
                clip: rect(0, 900px, 0, 0);
            }
            .shock:after {
                animation: shock-anim 2s infinite linear alternate-reverse;
                left: 2px;
                text-shadow: 2px 0 #001aff;
            }
            .shock:before {
                animation: shock 3s infinite linear alternate-reverse;
                left: -2px;
                text-shadow: -2px 0 rgb(255, 0, 0);
            }
            @keyframes shock-anim {
                0% { clip: rect(3px, 9999px, 93px, 0); }
                5% { clip: rect(53px, 9999px, 78px, 0); }
                10% { clip: rect(10px, 9999px, 75px, 0); }
                15% { clip: rect(32px, 9999px, 40px, 0); }
                20% { clip: rect(65px, 9999px, 62px, 0); }
                25% { clip: rect(31px, 9999px, 14px, 0); }
                30% { clip: rect(94px, 9999px, 87px, 0); }
                35% { clip: rect(81px, 9999px, 41px, 0); }
                40% { clip: rect(45px, 9999px, 50px, 0); }
                45% { clip: rect(82px, 9999px, 41px, 0); }
                50% { clip: rect(71px, 9999px, 3px, 0); }
                55% { clip: rect(75px, 9999px, 60px, 0); }
                60% { clip: rect(20px, 9999px, 49px, 0); }
                65% { clip: rect(67px, 9999px, 92px, 0); }
                70% { clip: rect(47px, 9999px, 55px, 0); }
                75% { clip: rect(63px, 9999px, 90px, 0); }
                80% { clip: rect(70px, 9999px, 92px, 0); }
                85% { clip: rect(41px, 9999px, 60px, 0); }
                90% { clip: rect(56px, 9999px, 79px, 0); }
                95% { clip: rect(21px, 9999px, 68px, 0); }
                100% { clip: rect(15px, 9999px, 72px, 0); }
            }
            @keyframes shock {
                0% { clip: rect(65px, 9999px, 99px, 0); }
                5% { clip: rect(86px, 9999px, 70px, 0); }
                10% { clip: rect(79px, 9999px, 60px, 0); }
                15% { clip: rect(15px, 9999px, 88px, 0); }
                20% { clip: rect(24px, 9999px, 5px, 0); }
                25% { clip: rect(35px, 9999px, 3px, 0); }
                30% { clip: rect(56px, 9999px, 11px, 0); }
                35% { clip: rect(2px, 9999px, 38px, 0); }
                40% { clip: rect(60px, 9999px, 50px, 0); }
                45% { clip: rect(27px, 9999px, 4px, 0); }
                50% { clip: rect(79px, 9999px, 12px, 0); }
                55% { clip: rect(23px, 9999px, 8px, 0); }
                60% { clip: rect(65px, 9999px, 55px, 0); }
                65% { clip: rect(19px, 9999px, 7px, 0); }
                70% { clip: rect(43px, 9999px, 17px, 0); }
                75% { clip: rect(65px, 9999px, 91px, 0); }
                80% { clip: rect(45px, 9999px, 66px, 0); }
                85% { clip: rect(3px, 9999px, 2px, 0); }
                90% { clip: rect(58px, 9999px, 81px, 0); }
                95% { clip: rect(29px, 9999px, 20px, 0); }
                100% { clip: rect(82px, 9999px, 28px, 0); }
            }

            .centeral ul ,.centeral ul li{
                display : block ;
                list-style: none ;
                padding : 0 ;
                margin : 0
            }
            .centeral ul {
                display: flex ;
                align-items: center ;
                justify-content: center
            }
            .centeral ul li {
                display : block ;
                position: relative;
            }
            .centeral ul li a {
                display : block ;
                text-decoration: none ;
                color : rgb(192, 192, 192) ;
                text-transform: uppercase;
                padding : 5px 20px;
                border-radius: 15px ;
                transition: all .3s ease ;
                font-weight: bold
            }
            .centeral ul li a:hover {
                background : #eee ;
            }

        }
    </style>
</head>
<body>
    <section class="centeral">
        <h1 class="shock" data-label="AMEN">AMEN</h1>
        <ul>
            <li>
                <a href="https://github.com/ghaninia/amen">github</a>
            </li>
            <li>
                <a href="https://documenter.getpostman.com/view/14577533/TzmBCtDy">api Document</a>
            </li>
        </ul>
    </section>
</body>
</html>
