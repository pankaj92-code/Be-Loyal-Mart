<?php
// PATH FIX: Ye file 'games' folder ke andar hai
include '../php/header.php'; 

// Agar user logged in nahi hai, toh header.php usey pehle hi index.php par bhej dega.
?>

<link rel="stylesheet" href="../assets/game-page-style.css" />
<title>Tic Tac Toe - Believers</title>

<div class="game-container card">
    <h1>Elite Mall Tic Tac Toe 🛍️</h1>
    <div id="gameBoard"></div>
    <div id="status">Your turn (X)</div>
    <button id="resetBtn" class="btn btn-ghost">Play Again</button>
  </div>

</main> </div> <script>
    // === Database Point Saving Function ===
    function savePointsToDatabase(points) {
        fetch('../php/update-points.php', { 
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ points: points })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Points saved successfully!');
            } else {
                console.error('Failed to save points:', data.message);
            }
        });
    }

    // === Game Logic ===
    const board = document.getElementById("gameBoard");
    const statusText = document.getElementById("status");
    const resetBtn = document.getElementById("resetBtn");

    let cells = Array(9).fill("");
    let gameActive = true;
    const PLAYER = "X";
    const COMPUTER = "O";
    const winningCombinations = [
      [0,1,2], [3,4,5], [6,7,8], [0,3,6], [1,4,7], [2,5,8], [0,4,8], [2,4,6]
    ];

    function createBoard() {
      board.innerHTML = "";
      cells.forEach((cell, i) => {
        const div = document.createElement("div");
        div.classList.add("cell");
        div.dataset.index = i;
        div.addEventListener("click", handlePlayerMove);
        board.appendChild(div);
      });
    }

    function handlePlayerMove(e) {
      const index = e.target.dataset.index;
      if (cells[index] || !gameActive) return;
      makeMove(index, PLAYER);
      if (checkWinner(PLAYER)) return endGame("player");
      if (isDraw()) return endGame("draw");
      statusText.textContent = "Computer’s turn 🤖...";
      setTimeout(computerMove, 700);
    }

    function makeMove(index, player) {
      cells[index] = player;
      const cellDivs = document.querySelectorAll(".cell");
      cellDivs[index].textContent = player;
      cellDivs[index].classList.add("taken");
    }

    function computerMove() {
      if (!gameActive) return;
      let move;
      const smartness = Math.random() < 0.8; 
      if (smartness) move = findBestMove();
      else {
        const available = cells.map((v,i)=>v===""?i:null).filter(v=>v!==null);
        move = available[Math.floor(Math.random() * available.length)];
      }
      makeMove(move, COMPUTER);
      if (checkWinner(COMPUTER)) return endGame("computer");
      if (isDraw()) return endGame("draw");
      statusText.textContent = "Your turn (X)";
    }

    function findBestMove() {
      for (let combo of winningCombinations) {
        const [a,b,c] = combo;
        if (cells[a] === COMPUTER && cells[b] === COMPUTER && !cells[c]) return c;
        if (cells[a] === COMPUTER && cells[c] === COMPUTER && !cells[b]) return b;
        if (cells[b] === COMPUTER && cells[c] === COMPUTER && !cells[a]) return a;
      }
      for (let combo of winningCombinations) {
        const [a,b,c] = combo;
        if (cells[a] === PLAYER && cells[b] === PLAYER && !cells[c]) return c;
        if (cells[a] === PLAYER && cells[c] === PLAYER && !cells[b]) return b;
        if (cells[b] === PLAYER && cells[c] === PLAYER && !cells[a]) return a;
      }
      if (!cells[4]) return 4;
      const corners = [0,2,6,8].filter(i => !cells[i]);
      if (corners.length) return corners[Math.floor(Math.random()*corners.length)];
      const sides = [1,3,5,7].filter(i => !cells[i]);
      return sides[Math.floor(Math.random()*sides.length)];
    }

    function checkWinner(player) {
      return winningCombinations.some(combo => {
        return combo.every(index => cells[index] === player);
      });
    }

    function isDraw() {
      return cells.every(c => c !== "");
    }

    function endGame(winner) {
      gameActive = false;
      if (winner === "player") {
        highlightWinningCombo(PLAYER);
        const points = Math.floor(Math.random() * 21) + 50; // 50–70 points
        savePointsToDatabase(points); 
        statusText.textContent = `🎉 You won! You earned ${points} reward points!`;
        setTimeout(() => alert(`🎁 Congrats! You earned ${points} reward points!`), 300);
      } else if (winner === "computer") {
        highlightWinningCombo(COMPUTER);
        statusText.textContent = "🤖 The computer won this round!";
      } else {
        statusText.textContent = "😅 It’s a draw!";
      }
    }

    function highlightWinningCombo(player) {
      const cellDivs = document.querySelectorAll(".cell");
      winningCombinations.forEach(combo => {
        if (combo.every(index => cells[index] === player)) {
          combo.forEach(i => cellDivs[i].classList.add("winner"));
        }
      });
    }

    function resetGame() {
      cells.fill("");
      gameActive = true;
      statusText.textContent = "Your turn (X)";
      createBoard();
    }

    resetBtn.addEventListener("click", resetGame);
    createBoard();
  </script>
</body>
</html>