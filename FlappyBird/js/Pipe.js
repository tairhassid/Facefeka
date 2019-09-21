// const Pipe = function (xPos, yPos, length, speed, ctx) {
//     this.xPos = xPos;
//     this.yPos = yPos;
//     this.length = length;
//     this.width = 150;
//     this.ctx = ctx;
//     this.speed = speed;
// }

// Pipe.prototype.update = function () {
//     this.xPos -= this.speed;
// }

// Pipe.prototype.render = function () {
//     this.ctx.save();
//     this.ctx.fillStyle = "#000000";
//     this.ctx.fillRect(this.xPos, this.yPos, this.width, this.length);
//     this.ctx.fillStyle = "#74BF2E";
//     this.ctx.fillRect(this.xPos + 2, this.yPos + 2, this.width - 4, this.length - 4);

//     this.ctx.restore();
// }


function Pipe(xPos, yPos, length, speed) {
    this.xPos = xPos;
    this.yPos = yPos;
    this.length = length;
    this.width = 150;
    this.speed = speed;

    this.update = function () {
        this.xPos -= this.speed;
    }

    this.render = function () {
        ctx = myGameArea.context;
        // this.ctx.save();
        ctx.fillStyle = "#000000";
        ctx.fillRect(this.xPos, this.yPos, this.width, this.length);
        ctx.fillStyle = "#74BF2E";
        ctx.fillRect(this.xPos + 2, this.yPos + 2, this.width - 4, this.length - 4);

        // this.ctx.restore();
    }
}