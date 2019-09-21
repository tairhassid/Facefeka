exports.newPipe = function (xPos, yPos, length, speed) {
    var self = {
        xPos: xPos,
        yPos: yPos,
        length: length,
        width: 150,
        speed: speed,

        update: function () {
            this.xPos -= this.speed;
        }

        // render: function () {
        //     // ctx = myGameArea.context;
        //     // this.ctx.save();
        //     ctx.fillStyle = "#000000";
        //     ctx.fillRect(this.xPos, this.yPos, this.width, this.length);
        //     ctx.fillStyle = "#74BF2E";
        //     ctx.fillRect(this.xPos + 2, this.yPos + 2, this.width - 4, this.length - 4);

        //     // this.ctx.restore();
        // }
    }

    return self;


}