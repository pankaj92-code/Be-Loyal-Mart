<?php
// PATH FIX: Ye file 'games' folder ke andar hai, isliye '../' zaroori hai
include '../php/db_connect.php'; 

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // PATH FIX: Wapas index.php par bhejein
    header("Location: ../index.php");
    exit();
}

// (Optional) Get user's data for use on this page
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Scratch & Win</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; flex-direction: column; align-items: center; background-color: #0D1B2A; color: #E0E0E0; padding: 20px; }
        h1 { color: #FFB300; text-shadow: 0 0 8px rgba(255, 179, 0, 0.3); }
        .message-box { margin-top: 20px; padding: 12px 20px; border-radius: 12px; background-color: #14243D; border: 1px solid #1E3A5F; color: #FFD54F; font-weight: bold; min-width: 300px; text-align: center; }
        .card-grid { display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 15px; width: 100%; max-width: 600px; margin-top: 25px; }
        .card { background-color: #1B2A41; border-radius: 15px; height: 150px; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); transition: transform 0.2s, box-shadow 0.2s; color: #FFD54F; font-size: 22px; font-weight: bold; user-select: none; border: 2px solid #FFB300; position: relative; }
        .card:hover { transform: translateY(-4px); box-shadow: 0 6px 10px rgba(255, 179, 0, 0.2); }
        .card.scratched { background-color: #263B5E; cursor: default; color: #B0BEC5; }
        .card .content { opacity: 0; transition: opacity 0.3s; }
        .card.scratched .content { opacity: 1; color: #FFD54F; }
        .scratch-surface { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #FFB300; border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 40px; color: #4A2800; transition: opacity 0.3s; }
        .card.scratched .scratch-surface { opacity: 0; pointer-events: none; }
    </style>
</head>
<body>
    <h1>Elite Scratch & Win 🤑</h1>
    <div class="message-box" id="message"> You have <b>2</b> scratches left today. </div>
    <div class="card-grid" id="cardGrid">
        <div class="card" data-prize=""><span class="content"></span><div class="scratch-surface">?</div></div>
        <div class="card" data-prize=""><span class="content"></span><div class="scratch-surface">?</div></div>
        <div class="card" data-prize=""><span class="content"></span><div class="scratch-surface">?</div></div>
        <div class="card" data-prize=""><span class="content"></span><div class="scratch-surface">?</div></div>
        <div class="card" data-prize=""><span class="content"></span><div class="scratch-surface">?</div></div>
        <div class="card" data-prize=""><span class="content"></span><div class="scratch-surface">?</div></div>
        <div class="card" data-prize=""><span class="content"></span><div class="scratch-surface">?</div></div>
        <div class="card" data-prize=""><span class="content"></span><div class="scratch-surface">?</div></div>
        <div class="card" data-prize=""><span class="content"></span><div class="scratch-surface">?</div></div>
    </div>

    <script>
        // === Database Point Saving Function ===
        function savePointsToDatabase(points) {
            // PATH FIX: 'games' folder se bahar 'php' folder mein jaana hai
            fetch('../php/update-points.php', { 
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ points: points })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Points saved!');
                } else {
                    console.error('Failed to save points:', data.message);
                }
            });
        }
        // ==================================

        // === Game Logic ===
        const MAX_SCRATCHES = 2;
        let scratchesLeft = MAX_SCRATCHES;
        const cards = document.querySelectorAll('.card');
        const messageBox = document.getElementById('message');
        
        // Prize list update kiya hai points ke saath
        const prizesList = [
            { text: '🤩 GIFT!', points: 50 },
            { text: '🤑 100 Points', points: 100 },
            { text: '💰 50 Points', points: 50 },
            { text: 'Better Luck Next Time', points: 0 },
            { text: 'Better Luck Next Time', points: 0 },
            { text: 'Better Luck Next Time', points: 0 },
            { text: 'Better Luck Next Time', points: 0 },
            { text: 'Better Luck Next Time', points: 0 },
            { text: 'Better Luck Next Time', points: 0 }
        ];

        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
        }

        function initializeGame() {
            shuffleArray(prizesList);
            cards.forEach((card, index) => {
                const prize = prizesList[index];
                card.setAttribute('data-prize', prize.