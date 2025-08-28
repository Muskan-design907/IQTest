<?php
// homepage.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Online IQ Test</title>
    <style>
        /* Reset and basic styling */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            color: #222;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: white;
            max-width: 600px;
            width: 100%;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
            text-align: center;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #0d47a1;
        }
        p {
            font-size: 1.125rem;
            line-height: 1.6;
            margin-bottom: 30px;
            color: #444;
        }
        .start-btn {
            background-color: #0d47a1;
            color: white;
            font-size: 1.25rem;
            padding: 15px 40px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .start-btn:hover {
            background-color: #09407f;
        }
        footer {
            margin-top: 40px;
            font-size: 0.875rem;
            color: #666;
        }
 
        /* Responsive */
        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }
            h1 {
                font-size: 2rem;
            }
            .start-btn {
                width: 100%;
                padding: 15px 0;
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container" role="main">
        <h1>Welcome to the Online IQ Test</h1>
        <p>
            IQ (Intelligence Quotient) tests measure a range of cognitive abilities including logical reasoning, 
            pattern recognition, numerical ability, and problem-solving skills. Taking this test will give you 
            insight into your cognitive strengths and areas for improvement.
        </p>
        <a href="quiz.php" class="start-btn" aria-label="Start IQ Test">Start Test</a>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> IQ Test Platform. All rights reserved.
    </footer>
</body>
</html>
 
