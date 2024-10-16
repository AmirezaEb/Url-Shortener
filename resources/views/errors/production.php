<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Something Went Wrong</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            text-align: center;
            max-width: 500px;
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-in-out;
        }

        .container h1 {
            font-size: 3rem;
            color: #e74c3c;
            margin-bottom: 20px;
        }

        .container p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .container img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        .container a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .container a:hover {
            background-color: #2980b9;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Floating animation for image */
        @keyframes float {
            0% {
                transform: translatey(0px);
            }
            50% {
                transform: translatey(-15px);
            }
            100% {
                transform: translatey(0px);
            }
        }

        .container img {
            animation: float 3s infinite;
        }

    </style>
</head>
<body>

    <div class="container">
        <img src="https://i.imgur.com/qIufhof.png" alt="Error Image">
        <h1>Oops!</h1>
        <p>Something went wrong. Please try again later.</p>
        <a href="/">Go to Homepage</a>
    </div>

</body>
</html>