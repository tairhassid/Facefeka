var socket = io();

var myEnv;
var birds = [];
var pipes = [];
var id;
var sprites = [document.getElementById('bird1'),
    document.getElementById('bird2'),
    document.getElementById('bird3')
];

var spritesForOtherPlayers = [document.getElementById('blueBird1'),
    document.getElementById('blueBird2'),
    document.getElementById('blueBird3')
];

var score;
var finished = false;

var btn = document.getElementById("beginPlay");
var playerName = document.getElementById("playerName");
var beginPage = document.getElementById("beginPage");
var gamePage = document.getElementById("gameOn");
var canvas = document.getElementById("canvas");

btn.onclick = function () {
    beginPage.style.display = "none";
    gamePage.style.display = "inline-block";
    canvas.style.display = "inline-block";
    startGame();
}

function startGame() {
    myGameArea.start();
    myEnv = new Environment();
    score = new Score("30px", "Consolas", "black", 280, 40);
    console.log("after start, emmiting new player");
    socket.emit('new player', playerName.value);
    id = socket.id;
}

var myGameArea = {
    canvas: document.getElementById('canvas'),
    start: function () {
        this.canvas.width = window.innerWidth;
        this.canvas.height = 630;
        this.context = this.canvas.getContext('2d');

        this.frameNo = 0;
        this.interval = setInterval(updateGameArea, 20);

        window.addEventListener('keydown', function (e) { //if spacebar is pressed, lift the bird up
            if (e.keyCode === 32) {
                socket.emit('press space');
            }
        })
    },
    clear: function () {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    },
    stop: function () {
        clearInterval(this.interval);
    }
}

socket.on('birds', function (data) {
    birds = data;
});

socket.on('pipes', function (data) {
    pipes = data;
})

socket.on('your_id', function (data) {
    id = data;
})

socket.on('winner', function (data) {
    if (!finished) {
        myGameArea.context.fillStyle = "#000000";
        myGameArea.context.font = "50px Arial";
        myGameArea.context.fillText("The Winner is " + data.name + "!", 500, 300);
        myGameArea.context.fillText(" Score: " + data.score, 500, 400);
    }
    finished = true;
})

function updateGameArea() {
    myGameArea.clear();
    myEnv.update();
    myEnv.render();

    for (let birdId in birds) {
        if (birdId == id) {
            myGameArea.context.fillStyle = "#000000";
            myGameArea.context.fillText("You", birds[birdId].x + birds[birdId].width / 4, birds[birdId].renderY);
            myGameArea.context.drawImage(sprites[birds[birdId].spriteIdx], birds[birdId].x, birds[birdId].renderY);
        } else
            myGameArea.context.drawImage(spritesForOtherPlayers[birds[birdId].spriteIdx], birds[birdId].x, birds[birdId].renderY);

    }

    for (var i = 0; i < pipes.length; i++) {
        pipes[i].xPos -= 3;
        myGameArea.context.fillStyle = "#000000";
        myGameArea.context.fillRect(pipes[i].xPos, pipes[i].yPos, pipes[i].width, pipes[i].length);
        myGameArea.context.fillStyle = "#74BF2E";
        myGameArea.context.fillRect(pipes[i].xPos + 2, pipes[i].yPos + 2, pipes[i].width - 4, pipes[i].length - 4);
    }

    var bird = birds[id];

    if (!detectCollisions(bird, pipes)) {
        myGameArea.frameNo += 1;
        score.update(myGameArea.frameNo);
    } else {
        myGameArea.stop();
        socket.emit("failed", bird, myGameArea.frameNo);
    }
}

function detectCollisions(bird, pipes) {
    if (bird.y + bird.height / 2 >= canvas.height) {
        return true;
    }
    for (var i = 0; i < pipes.length; i++) {
        let p = pipes[i];
        let birdX = bird.x + bird.width;
        let highPipe = p.yPos <= 0;
        let x0 = p.xPos,
            x1 = p.xPos + p.width;
        if (birdX > x0 && birdX < x1) {
            if (highPipe) {
                let y0 = p.yPos + p.length;
                let birdY = bird.y - bird.height / 2;
                if (birdY < y0)
                    return true;
            } else {
                let y1 = p.yPos;
                let birdY = bird.y + bird.height / 2;
                if (birdY > y1)
                    return true;
            }
        }
    }
    return false;
}