<?php
session_start();
 
// Define questions as an array of arrays
$questions = [
    1 => [
        'question' => 'What number comes next in the series? 2, 4, 8, 16, ?',
        'options' => [
            'A' => '18',
            'B' => '24',
            'C' => '32',
            'D' => '20'
        ],
        'correct' => 'C'
    ],
    2 => [
        'question' => 'Which shape completes the pattern? ◼️, ◻️, ◼️, ◻️, ?',
        'options' => [
            'A' => '◼️',
            'B' => '◻️',
            'C' => '▲',
            'D' => '●'
        ],
        'correct' => 'A'
    ],
    3 => [
        'question' => 'If ALL BARKS are trees, and ALL TREES are plants, then ALL BARKS are?',
        'options' => [
            'A' => 'Plants',
            'B' => 'Animals',
            'C' => 'Minerals',
            'D' => 'Bacteria'
        ],
        'correct' => 'A'
    ],
    4 => [
        'question' => 'Find the missing number: 5, 10, 20, 40, ?',
        'options' => [
            'A' => '80',
            'B' => '90',
            'C' => '100',
            'D' => '70'
        ],
        'correct' => 'A'
    ],
    5 => [
        'question' => 'Which word is the odd one out?',
        'options' => [
            'A' => 'Circle',
            'B' => 'Square',
            'C' => 'Triangle',
            'D' => 'Rectangle'
        ],
        'correct' => 'A'
    ],
];
 
// Process form submission and save answer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question_id'], $_POST['answer'])) {
    $qid = (int)$_POST['question_id'];
    $answer = $_POST['answer'];
    $_SESSION['answers'][$qid] = $answer;
 
    // Redirect to next question or results page
    $totalQuestions = count($questions);
    $next = $qid + 1;
 
    if ($next > $totalQuestions) {
        header("Location: results.php");
    } else {
        header("Location: quiz.php?q=" . $next);
    }
    exit();
}
 
// Get current question index from GET or default to 1
$current = isset($_GET['q']) ? (int)$_GET['q'] : 1;
if ($current < 1) $current = 1;
if ($current > count($questions)) $current = count($questions);
 
$currentQuestion = $questions[$current];
$answered = $_SESSION['answers'][$current] ?? null;
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>IQ Test - Question <?php echo $current; ?></title>
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
        max-width: 700px;
        width: 100%;
        padding: 30px 25px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgb(0 0 0 / 0.1);
    }
    h2 {
        margin-bottom: 15px;
        color: #0d47a1;
    }
    form {
        margin-top: 20px;
    }
    .options {
        list-style: none;
        padding: 0;
    }
    .options li {
        margin-bottom: 15px;
    }
    label {
        font-size: 1.125rem;
        cursor: pointer;
        user-select: none;
        display: flex;
        align-items: center;
    }
    input[type="radio"] {
        margin-right: 12px;
        width: 20px;
        height: 20px;
    }
    .navigation {
        margin-top: 25px;
        display: flex;
        justify-content: space-between;
    }
    button, .submit-btn {
        background-color: #0d47a1;
        color: white;
        font-size: 1.1rem;
        padding: 12px 28px;
        border: none;
        border-radius: 40px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    button[disabled] {
        background-color: #a1a1a1;
        cursor: not-allowed;
    }
    button:hover:not([disabled]), .submit-btn:hover {
        background-color: #09407f;
    }
    .progress {
        margin-bottom: 20px;
        font-size: 1rem;
        color: #555;
    }
    @media (max-width: 480px) {
        .container {
            padding: 20px 15px;
        }
        button, .submit-btn {
            width: 100%;
            margin-bottom: 12px;
        }
        .navigation {
            flex-direction: column;
            gap: 12px;
        }
    }
</style>
</head>
<body>
<div class="container" role="main" aria-live="polite">
    <h2>Question <?php echo $current; ?> of <?php echo count($questions); ?></h2>
    <p class="progress">Please select the best answer:</p>
    <form method="POST" action="quiz.php?q=<?php echo $current; ?>">
        <p style="font-size:1.25rem; margin-bottom: 20px;"><?php echo htmlspecialchars($currentQuestion['question']); ?></p>
        <ul class="options" role="radiogroup" aria-labelledby="questionText">
            <?php foreach ($currentQuestion['options'] as $key => $option): ?>
                <li>
                    <label>
                        <input
                            type="radio"
                            name="answer"
                            value="<?php echo $key; ?>"
                            required
                            aria-checked="<?php echo ($answered === $key) ? 'true' : 'false'; ?>"
                            <?php echo ($answered === $key) ? 'checked' : ''; ?>
                        />
                        <strong><?php echo $key; ?>.</strong> <?php echo htmlspecialchars($option); ?>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
        <input type="hidden" name="question_id" value="<?php echo $current; ?>" />
        <div class="navigation">
            <button type="button" onclick="goToQuestion(<?php echo $current - 1; ?>)" <?php echo ($current === 1) ? 'disabled' : ''; ?> aria-disabled="<?php echo ($current === 1) ? 'true' : 'false'; ?>">Previous</button>
            <?php if ($current < count($questions)): ?>
                <button type="submit">Save & Next</button>
            <?php else: ?>
                <button type="submit" formaction="results.php" class="submit-btn">Finish Test</button>
            <?php endif; ?>
        </div>
    </form>
</div>
 
<script>
function goToQuestion(q) {
    if (q < 1) q = 1;
    if (q > <?php echo count($questions); ?>) q = <?php echo count($questions); ?>;
    window.location.href = 'quiz.php?q=' + q;
}
</script>
</body>
</html>
 
