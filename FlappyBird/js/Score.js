function Score(width, font, color, x, y) {
    this.width = width;
    this.font = font;
    this.color = color;
    this.x = x;
    this.y = y;

    this.update = function (frameNo) {
        ctx = myGameArea.context;
        ctx.font = this.width + " " + this.font;
        ctx.fillStyle = this.color;
        ctx.fillText("Score: " + frameNo, this.x, this.y);
    }
}