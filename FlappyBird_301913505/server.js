// Dependencies
var express = require('express');
var http = require('http');
var path = require('path');
var socketIO = require('socket.io');
var app = express();
var server = http.Server(app);
var io = socketIO(server);

var bird = require('./Bird');
var pipe = require('./Pipe');

var birdsList = {};
var pipesList = [];
var sockets = {};
var numOfPlayers = 0;

var canvasHeight = 620;
var canvasWidth = 1366;

app.set('port', 5000);
app.use('/', express.static(__dirname + '/'));

app.get('/', function (request, response) {
    response.sendFile(path.join(__dirname, '/index.html'));
});

app.get('/images/bird1.png', function (request, response) {
    response.sendFile(path.join(__dirname, 'images/bird1.png'));
});

app.get('/images/bird2.png', function (request, response) {
    response.sendFile(path.join(__dirname, 'images/bird2.png'));
});

app.get('/images/bird3.png', function (request, response) {
    response.sendFile(path.join(__dirname, 'images/bird3.png'));
});

app.get('/images/bg2.jpg', function (request, response) {
    response.sendFile(path.join(__dirname, 'images/bg2.jpg'));
});

app.get('/stylesheet.css', function (request, response) {
    response.sendFile(path.join(__dirname, '/stylesheet.css'));
});

app.get('/js/Environment.js', function (request, response) {
    response.sendFile(path.join(__dirname, '/js/Environment.js'));
});

app.get('/js/main.js', function (request, response) {
    response.sendFile(path.join(__dirname, '/js/main.js'));
});

app.get('/js/Score.js', function (request, response) {
    response.sendFile(path.join(__dirname, '/js/Score.js'));
});

// Starts the server.
server.listen(5000, function () {
    console.log('Starting server on port 5000');
    createPipes();
});

io.on('connection', function (socket) {

    socket.on('new player', function (data) {
        numOfPlayers += 1;
        console.log("new player " + numOfPlayers);
        birdsList[socket.id] = bird.newBird(250, 300, data);
        sockets[socket.id] = socket;
        socket.emit('your_id', socket.id);
        socket.emit('pipes', pipesList);
    });


    socket.on('disconnect', function (myPlayer) {
        delete birdsList[socket.id];
        numOfPlayers--;
    });

    socket.on('press space', function () {
        var player = birdsList[socket.id] || {};
        player.velY = -16;
    })

    socket.on('failed', function (failedPlayer, score) {
        var winner;
        var playersCounter = 0;

        for (let id in birdsList) {
            playersCounter++;
            console.log("counter " + playersCounter);
        }
        if (playersCounter == 1) {
            winner = bird.newBird(250, 300, failedPlayer.name);
            winner.score = score;
            io.sockets.emit('winner', winner);
        }
        delete birdsList[socket.id];
    })

});

setInterval(function () {
    var birdPack = [];
    var pipePack = [];

    for (var i in birdsList) {
        var bird = birdsList[i];
        bird.update();
        bird.render();
    }

    for (var i in sockets) {
        var s = sockets[i];
        s.emit('birds', birdsList);
    }
}, 1000 / 60);

function createPipes() {
    var x = 700;
    for (let i = 0; i < 150; i++) {
        let pipeSet = generatePipesLengths(x);
        x += 500;
        pipesList.push(pipeSet.top, pipeSet.bottom);
    }
}

function generatePipesLengths(x) {
    let gapLength = Math.round(Math.random() * 250 + 200);
    let lengthTop = Math.round(Math.random() * (325 - gapLength) + 200);
    let lenghtBottom = canvasHeight - gapLength - lengthTop;

    let returnVal = {};
    returnVal.top = pipe.newPipe(x, -5, lengthTop, 4);
    returnVal.bottom = pipe.newPipe(x, canvasHeight + 5 - lenghtBottom, lenghtBottom, 4);
    return returnVal;
}