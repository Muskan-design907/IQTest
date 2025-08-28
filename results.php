<?php
session_start();
 
// Define the same questions with correct answers to score
$questions = [
    1 => ['correct' => 'C'],
    2 => ['correct' => 'A'],
    3 => ['correct' => 'A'],
    4 => ['correct' => 'A'],
    5 => ['correct' => 'A'],
];
 
// Retrieve user answers from session
$userAnswers = $_SESSION['answers'] ?? [];
 
// Calculate score
$totalQuestions = count($questions);
$correctCount = 0;
 
foreach ($questions as $qid => $data) {
    if (isset($userAnswers[$qid]) && $userAnswers[$qid] === $data['correct']) {
        $correctCount++;
    }
}
 
// Calculate percentage score
$percentage = ($correctCount / $totalQuestions) * 100;
 
// Simple IQ score calculation (scale 70-130)
// 70 = 0% correct, 130 = 100% correct
$iqScore = round(70 + ($percentage * 0.6));
 
// Feedback based on IQ score
function getFeedback($iq) {
    if ($iq < 85) {
        return "Your cognitive skills could use improvement. Practice problem-solving and reasoning exercises.";
    } elseif ($iq < 100) {
        return "You have average cognitive abilities. With some focus, you can enhance your skills further.";
    } elseif ($iq < 115) {
        return "Good job! Your cognitive abilities are above average.";
    } elseif ($iq < 130) {
        return "Excellent! You have high cognitive abilities and strong problem-solving skills.";
    } else {
        return "Outstanding! You exhibit exceptional intelligence and reasoning ability.";
    }
}
 
$feedback = getFeedback($iqScore);
 
// Clear session answers to allow retake
// Comment this if you want to keep answers for other use
session_unset();
session_destroy();
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>IQ Test Results</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f0f4f8;
        color: #222;
        padding: 20px;
        display: flex;
        justify-content: center;
        min-height: 100vh;
    }
    .container {
        background: white;
        max-width: 600px;
        width: 100%;
        padding: 30px 25px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgb(0 0 0 / 0.1);
        text-align: center;
    }
    h1 {
        color: #0d47a1;
        margin-bottom: 10px;
        font-size: 2.2rem;
    }
    .score {
        font-size: 4rem;
        font-weight: 700;
        color: #0d47a1;
        margin: 20px 0;
    }
    .feedback {
        font-size: 1.125rem;
        margin-bottom: 30px;
        color: #444;
        line-height: 1.5;
    }
    .buttons {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    .btn {
        background-color: #0d47a1;
        color: white;
        font-size: 1.125rem;
        padding: 12px 32px;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s ease;
        user-select: none;
        display: inline-block;
    }
    .btn:hover {
        background-color: #09407f;
    }
    .btn:active {
        transform: scale(0.97);
    }
    @media (max-width: 480px) {
        .container {
            padding: 25px 15px;
        }
        .score {
            font-size: 3rem;
        }
        .buttons {
            flex-direction: column;
            gap: 15px;
        }
        .btn {
            width: 100%;
            padding: 14px 0;
            font-size: 1.1rem;
        }
    }
</style>
</head>
<body>
<div class="container" role="main" aria-live="polite">
    <h1>Your IQ Score</h1>
    <div class="score" aria-label="IQ score"><?php echo $iqScore; ?></div>
    <div class="feedback"><?php echo htmlspecialchars($feedback); ?></div>
    <div class="buttons">
        <a href="quiz.php" class="btn" aria-label="Retake the IQ test">Retake Test</a>
        <a href="homepage.php" class="btn" aria-label="Go to homepage">Home</a>
        <button class="btn" onclick="shareResults()" aria-label="Share your IQ score">Share</button>
    </div>
</div>
 
<script>
function shareResults() {
    const iq = <?php echo $iqScore; ?>;
    const shareText = `I just scored ${iq} on this online IQ Test! Try it yourself: ${window.location.origin}/homepage.php`;
 
    if (navigator.share) {
        navigator.share({
            title: 'My IQ Test Result',
            text: shareText,
            url: window.location.origin + '/homepage.php'
        }).catch(console.error);
    } else {
        // fallback: copy to clipboard
        navigator.clipboard.writeText(shareText).then(() => {
            alert('Result copied to clipboard! You can now share it.');
        }, () => {
            alert('Sharing not supported on your browser. Please copy the text manually:\n\n' + shareText);
        });
    }
}
</script>
</body>
</html>
 
