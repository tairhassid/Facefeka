// const Bird = function (x, y, ctx) {
//     this.x = x;
//     this.y = y;
//     this.ctx = ctx;
//     this.velY = 0;
//     this.width = 90;
//     this.height = 64;
//     this.ticks = 0;
//     this.spriteIdx = 0;

//     //to animate the bird
//     this.sprites = [document.getElementById('bird1'),
//         document.getElementById('bird2'),
//         document.getElementById('bird3')
//     ];

//     var self = this;
//     window.addEventListener('keydown', function (e) { //if spacebar is pressed, lift the bird up
//         if (e.keyCode === 32) {
//             self.velY = -16;
//         }
//     })
// }

// Bird.prototype.update = function () {
//     this.ticks++;
//     if (this.ticks % 10 === 0)
//         this.spriteIdx = (this.spriteIdx + 1) % this.sprites.length;
//     this.y += this.velY;
//     this.velY += 1.25; //each time the bird will be drawn it will be lower
// }

// Bird.prototype.render = function () {
//     let renderX = this.x - this.width / 2;
//     let renderY = this.y - this.height / 2;
//     this.ctx.drawImage(this.sprites[this.spriteIdx], renderX, renderY);
// }


function Bird(x, y) {
    this.x = x;
    this.y = y;
    //this.ctx = ctx;
    this.velY = 0;
    this.width = 90;
    this.height = 64;
    this.ticks = 0;
    this.spriteIdx = 0;

    //to animate the bird
    this.sprites = [document.getElementById('bird1'),
        document.getElementById('bird2'),
        document.getElementById('bird3')
    ];

    this.update = function () {
        this.ticks++;
        if (this.ticks % 10 === 0)
            this.spriteIdx = (this.spriteIdx + 1) % this.sprites.length;
        this.y += this.velY;
        this.velY += 1.25; //each time the bird will be drawn it will be lower
    }

    this.render = function () {
        ctx = myGameArea.context;
        let renderX = this.x - this.width / 2;
        let renderY = this.y - this.height / 2;
        ctx.drawImage(this.sprites[this.spriteIdx], renderX, renderY);
    }
}