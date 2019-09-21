exports.newBird = function (x, y, name) {
    var self = {
        x: x,
        y: y,
        velY: 0,
        width: 90,
        height: 64,
        ticks: 0,
        spriteIdx: 0,
        renderY: 0,
        score: 0,
        name: name,
        render: function () {
            // ctx = myGameArea.context;
            let renderX = this.x - this.width / 2;
            this.renderY = this.y - this.height / 2;
            // ctx.drawImage(this.sprites[this.spriteIdx], renderX, renderY);
        },
        update: function () {
            this.ticks++;
            if (this.ticks % 10 === 0)
                this.spriteIdx = (this.spriteIdx + 1) % 3;
            this.y += this.velY;
            this.velY += 1.25; //each time the bird will be drawn it will be lower
        }
    }
    return self;

}