<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    <style>
        body{  overflow:hidden;  margin:0;  padding:0;  }  main{  background:url("<?= assetUrl('img/backGround.webp')?>");  background-size:cover;  height:100vh;  font-family:"Avenir",sans-serif;  overflow:hidden;  position:relative;  }  .NotPageContainer{  position:relative;  z-index:10;  display:flex;  justify-content:center;  align-items:center;  height:100vh;  width:100vw;  }  .notTitle{  display:flex;  align-items:center;  }  .num-style{  font-size:30vmin;  color:#713dea;  margin:0 2rem;  }  .cog-wheel{  transform:scale(0.7);  }  .cog{  width:30vmin;  height:30vmin;  border-radius:50%;  border:6.5vmin solid #f3c623;  position:relative;  }   .top,  .down,  .left,  .right,  .left-top,  .left-down,  .right-top,  .right-down{  width:9vmin;  height:9vmin;  background-color:#f3c623;  position:absolute;  }  .right-cog .top,  .right-cog .down,  .right-cog .left,  .right-cog .right,  .right-cog .left-top,  .right-cog .left-down,  .right-cog .right-top,  .right-cog .right-down{  background-color:#713dea;  }  .top{  top:-14vmin;  left:10vmin;  }  .down{  bottom:-14vmin;  left:10vmin;  }  .left{  left:-14vmin;  top:10vmin;  }  .right{  right:-14vmin;  top:10vmin;  }  .left-top{  transform:rotateZ(-45deg);  left:-7vmin;  top:-7vmin;  }  .left-down{  transform:rotateZ(45deg);  left:-8vmin;  top:27vmin;  }  .right-top{  transform:rotateZ(45deg);  right:-7vmin;  top:-7vmin;  }  .right-down{  transform:rotateZ(-45deg);  right:-8vmin;  top:28vmin;  }  .right-cog .right-down{  top:27vmin !important;  }  .notPageDetails{  text-align:center;  }  .notPageDetails__error{  color:#fff;  font-size:5vmin;  font-weight:bold;  animation:bulbing ease-in-out;  animation-duration:3s;  animation-iteration-count:infinite;  }  .notPageDetails__desc{  font-size:3vmin;  color:#999999;  margin:0 0 .4rem;  }  .notPageButtonDiv{  display:flex;  justify-content:center;  align-items:center;  margin-top:1rem;  }  .button{  background-color:#4e0de5;  color:white;  align-items:center;  justify-content:center;  font-size:1.2vw;  border:1px solid #2f0889;  border-radius:10px;  padding:15px;  margin-left:15px;  display:flex;  transition-duration:0.2s;  cursor:pointer;  }  .button:hover{  background-color:#460cce;  }  .notPageButton{  text-decoration:none;  font-size:3vmin;  }  .bg-blur{  position:absolute;  content:'';  top:0;  left:0;  width:100vw;  height:100vh;  background-color:rgba(0,0,0,.5);  backdrop-filter:blur(10px);  }  @keyframes bulbing{  0%{   opacity:1;   }  50%{   opacity:0;   }  100%{   opacity:1;   }  }
    </style>
</head>

<body>
    <main>
        <div class="NotPageContainer">
            <div>
                <div class="notTitle">
                    <h2 class="num-style">4</h2>
                    <!-- cog of zero -->
                    <div class="cog-wheel">
                        <div class="cog">
                            <div class="top"></div>
                            <div class="down"></div>
                            <div class="left-top"></div>
                            <div class="left-down"></div>
                            <div class="right-top"></div>
                            <div class="right-down"></div>
                            <div class="left"></div>
                            <div class="right"></div>
                        </div>
                    </div>
                    <h2 class="num-style">4</h2>
                </div>
                <div class="notPageDetails">
                    <h2 class="notPageDetails__error">Oops... !</h2>
                    <p class="notPageDetails__desc">It Look Like You're Lost...</p>
                    <p class="notPageDetails__desc">Click On Button To Return Home Page !</p>
                </div>
                <div class="notPageButtonDiv">
                    <a href="<?= $_ENV['APP_HOST'] ?>" class="notPageButton button">Go Home Page</a>
                </div>
            </div>
        </div>
        <div class="bg-blur"></div>
    </main>
    <script src="<?= assetUrl('js/gsap.min.js')?>"></script>
    <script>
        const bgBlurZindex=document.querySelector('.bg-blur')
        const firstCog=document.querySelector('.cog')
        const secondCog=document.querySelector('.right-cog')
        if(firstCog){let leftCog=gsap.timeline();leftCog.to(".cog",{transformOrigin:"50% 50%",rotation:"+=360",repeat:-1,ease:Linear.easeNone,duration:8});}
        if(secondCog){let rightCog=gsap.timeline();rightCog.to(".right-cog",{transformOrigin:"50% 50%",rotation:"-=360",repeat:-1,ease:Linear.easeNone,duration:8});}
    </script>
</body>

</html>