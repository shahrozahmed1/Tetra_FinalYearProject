<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Tetra Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" type="text/css" href="styles/styles.css">
    <!--<style>

        body {
            height: 100vh;
            background: url("images/loris_venom.jpg") 50% fixed;
            background-size: cover;
        }
        
        
        * {
            box-sizing: border-box;
        }
        
        .wrapper {
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: center;
            width: 100%;
            min-height: 100%;
            padding: 20px;
            background: rgba(51,51,51, 0.85);
        }
        
        .login {
            border-radius: 2px 2px 5px 5px;
            padding: 10px 20px 20px 20px;
            width: 90%;
            max-width: 320px;
            background: #ffffff;
            position: relative;
            padding-bottom: 80px;
            box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.3);
        }
    
        .login input {
            display: block;
            padding: 15px 10px;
            margin-bottom: 10px;
            width: 100%;
            border: 1px solid #ddd;
            transition: border-width 0.2s ease;
            border-radius: 2px;
            color: #ccc;
        }
        
        .login input+i.fa {
            color: #fff;
            font-size: 1em;
            position: absolute;
            margin-top: -47px;
            opacity: 0;
            left: 0;
            transition: all 0.1s ease-in;
        }
        
        .login input:focus {
            outline: none;
            color: #444;
            border-color: DarkSeaGreen;
            border-left-width: 35px;
        }
        
        .login input:focus+i.fa {
            opacity: 1;
            left: 30px;
            transition: all 0.25s ease-out;
        }
        
        .login .title {
            color: #444;
            font-size: 1.2em;
            text-align: center;
            font-weight: bold;
            margin: 10px 0 30px 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }
        
        .login button {
            width: 100%;
            height: 100%;
            padding: 10px 10px;
            background: DarkSeaGreen;
            color: #fff;
            display: block;
            border: none;
            margin-top: 20px;
            position: absolute;
            left: 0;
            bottom: 0;
            max-height: 60px;
            border: 0px solid rgba(0, 0, 0, 0.1);
            border-radius: 0 0 2px 2px;
            transform: rotateZ(0deg);
            transition: all 0.1s ease-out;
            border-bottom-width: 7px;
        }

    </style>-->

</head>

<body>
    <div class="wrapper">
        <form class="login" action="dv_login.php" method="post">
            <p class="title">TETRA 2.0</p>
            <input type="text" placeholder="Username" name="username" autofocus required/>
            <i class="fa fa-user"></i>
            <input type="password" placeholder="Password" name="password" required/>
            <i class="fa fa-key"></i>
             <button type="submit">
      <i class="spinner"></i>
      <span class="state">Log in</span>
    </button>
        </form>
    </div>

</body>

</html>
