function Environment() {
    this.bgPos = 0;
    this.bgSpeed = 2;
    this.bgWidth = 450;
    this.bgImage = document.getElementById('bg');

    this.update = function () {
        this.bgPos -= this.bgSpeed;
        if (this.bgPos < -this.bgWidth)
            this.bgPos = 0;

    }

    this.render = function () {
        ctx = myGameArea.context;
        for (let i = 0; i <= myGameArea.canvas.width / this.bgWidth + 1; i++)
            ctx.drawImage(this.bgImage, this.bgPos + i * this.bgWidth, 0);
    }
}