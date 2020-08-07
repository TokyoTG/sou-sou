<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>YBA| Home</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('dashboard/assets/apple-touch-icon.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('dashboard/assets/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('dashboard/assets/favicon-16x16.png')}}">
<link rel="manifest" href="{{asset('dashboard/assets/site.webmanifest')}}">
        <!-- Styles -->
        <style>
            *{
                padding: 0;
                margin: 0;
                box-sizing: border-box;
                text-decoration: none;
            }

         
            .top-right{
                padding: 10px 15px;
                background: white;
                font-family: 'Nunito', sans-serif;
                display: flex;
                justify-content: space-around;
            }

            .top-right a{
                display: inline-block;
                margin-right: 15px;
                padding: 10px 15px;
                transition: .3s;
                font-size: 1.1em;
                color: #212121;
                font-weight: 600;
            }
            .top-right h2{
                margin-right: auto;
            }

            .top-right  .register{
                border: 1px solid #4e73df;
                border-radius: 5px;
                background: #4e73df;
                color: #fff ;
            }

            .links.register:hover{
                background: #fff;
                color:#4e73df ;
            }

            .links:hover{
                 color: #4e73df;
                 /* text-decoration: underline; */
            }

            #menu{
                display: none;
            }

            #link-container{
                width: unset;
                height: unset;
                transition: .5s;
            }

            #close-btn{
                display: none;
            }
            #menu{
                display: none;
            }

            #welcome{
                margin-top: 20px;
                position: relative;
                font-family: 'Oswald', sans-serif;
                background: #4e73df;
                min-height: 350px;
                color: #f1f1f1;
            }

            #welcome h1{
                font-size: 3em;

            }

            #w-text{
                position: absolute;
                top:50%;
                left: 50%;
                transform: translate(-50%,-50%);
            }

            #how{
                text-align: center;
                font-family: 'Oswald', sans-serif;
                margin-top: 20px;
            }



            .content{
                width: 100%;
                padding: 10px 25px;
                text-align: center;
            }
            .cards{
                display: inline-block;
                width: 300px;
                position: relative;
                padding: 15px 5px 0px 5px;
                height: 420px;
                margin: 15px;
                background: #4e73df;
                border-radius: 15px;
            }


            .cards img{
                width: 100%;
                height: 300px;
            }


            .cards p{
                color: #fff;
                font-size: 1.2em;
                font-family: 'Nunito', sans-serif;
                padding: 5px 10px;
                font-weight: 600;
                /* position: absolute;
                top: 10px; */
            }


            @media only screen and (max-width: 650px) {
                /* .top-right .links{
                  display: none;
              } */
              #menu{
                display: block;
                cursor: pointer;
            }

         
            #link-container{
                    background: #fff;
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 0;
                    padding-top: 20px;
                    z-index: 100;
                    height: 100vh;
                    overflow: hidden;
                }
                .top-right a{
                    display: block;
                    margin-top: 10px;
                    width: 50%;
                }

                .top-right  .register{
                border: 0px solid #4e73df;
                border-radius: 5px;
                background: none;
                color: #212121 ;
            }
            #close-btn{
                display: block;
                font-size: 3.5em;
                font-weight: bold;
                position: absolute;
                top: 0;
                right: 20px;
                cursor: pointer;
            }

            .rotate {
                transform: rotate(-45deg);
                transition: all 1s ease-in;
            }

            #w-text{
                position: absolute;
                top:50%;
                left: 55%;
                width: 100%;
                transform: translate(-50%,-50%);
            }


            #welcome h1{
                font-size: 2.5em;

            }

            
            }


        </style>
    </head>
    <body>
        <div id="wrapper">
       
                <div class="top-right">
                    <h2>Y B A</h2>
                   <p id="menu" onclick="menu()">Menu</p>
                   <div id="link-container">
                    <p id="close-btn" onclick="closeMenu(this)">+</p>
                    <a href="{{ route('welcome') }}" class="links">Home</a>
                    {{-- <a href="#" class="links">About</a> --}}
                    @if ( Cookie::get('full_name') &&  Cookie::get('role'))
                    <a href="{{ route('logout') }}" class="links">Logout</a>
                    <a href="{{ route('dashboard.index') }}" class="links register">Dashboard</a>
                    @else
                        
                    <a href="{{ route('login') }}" class="links">Login</a>
                    <a href="{{ route('register') }}" class="links register">Register</a>
                    @endif
                 
                   </div>
            
                  
                </div>
            <div id="welcome">
                <div id="w-text">
                    <h1>Welcome to Your Blessings Awaits</h1>
                    {{-- <p>The online...........</p>  --}}
                </div>
               
            </div>
            <div id="how">
                <h1>How it Works</h1>
            </div>
            <div class="content">
                <div class="cards">
                    <p>Join Wait List</p>
                    <div>
                    <img src="{{asset('dashboard/assets/img/join_list.svg')}}" alt="">
                    </div>
                    
                </div>
                <div class="cards">
                    <p>Get Added to Group</p>
                    <div>
                    <img src="{{asset('dashboard/assets/img/admin.svg')}}" alt="">
                    </div>
                   
                </div>
                <div class="cards">
                    <p>Bless Group Top User</p>
                    <div>
                    <img src="{{asset('dashboard/assets/img/bless.svg')}}" alt="">
                    </div>
                   
                </div>
                <div class="cards">
                    <p>Continue Till you get to the Top</p>
                    <div>
                    <img src="{{asset('dashboard/assets/img/top.svg')}}" alt="">
                    </div>
                    
                </div>
            </div>
        </div>
    <script>
        let btn = document.getElementById('menu');
        function menu(){
            let links = document.getElementById('link-container');
            let close_btn = document.getElementById('close-btn');
            close_btn.classList.add('rotate');
            links.style.width = '60%';
        }
        function closeMenu(close_btn){
            let links = document.getElementById('link-container');
            links.style.width = '0';
            close_btn.classList.remove('rotate');
        }
        
    </script>
    </body>
    
</html>
