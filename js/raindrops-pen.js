'use strict';

/*
 *  Query UI plugin for raindrops on water effect.
 *  https://github.com/d-harel/raindrops.git
 */
$.widget("water.raindrops", {
    options: {
        canvasWidth: 0,      // Width of the  water. Default is 100% of the parent's width
        canvasHeight: 0,     // Height of the water. Default is 50% of the parent's height
        color: '#00aeef',    // Water Color
        rightPadding: 20,    // To cover unwanted gaps created by the animation.
        drawPenguins: true,  // Whether draw penguins or not.
        shakeIce: true,
        iceColor: 'rgba(137, 211, 245, 0.9)', // Color to draw the ice with.
        iceVelocity: 1,      // Speed to move ice.
        randomWords: ['ぺんぺん！', '❤'],
        wordColor: 'red',
        handleMouse: true,
        position: 'absolute',
        positionBottom: 0,
        positionLeft: 0
    },

    _create: function () {
        const canvas = window.document.createElement('canvas');
        if (!this.options.canvasHeight) {
            this.options.canvasHeight = this.element.height() / 2;
        }
        if (!this.options.canvasWidth) {
            this.options.canvasWidth = this.element.width();
        }
        this.options.realWidth = this.options.canvasWidth + this.options.rightPadding;
        canvas.height = this.options.canvasHeight;
        canvas.width = this.options.realWidth;

        this.ctx = canvas.getContext('2d');
        this.ctx.fillStyle = this.options.color;
        this.element.append(canvas);
        canvas.parentElement.style.overflow = 'hidden';
        canvas.parentElement.style.position = 'relative';
        canvas.style.position = this.options.position;
        canvas.style.bottom = this.options.positionBottom;
        canvas.style.left = this.options.positionLeft;
        canvas.style.display = 'block';

        this.springs = [];
        for (let i = 0; i < this.options.realWidth / 6; i++) {
            this.springs[i] = 0;
        }

        if (this.options.drawPenguins) {
            // Compute lighten/darken color for the ice.

            // 1. Draw with specified color to retrive actual color value.
            //     TODO: Can we avoid using temporary canvas here?
            const tmpCanvas = document.createElement('canvas');
            tmpCanvas.height = 1;
            tmpCanvas.width = 1;
            const tmpCtx = tmpCanvas.getContext('2d');
            tmpCtx.fillStyle = this.options.iceColor;
            tmpCtx.fillRect(0, 0, 1, 1);

            // 2. Retrive color and compute new color
            const imgData = tmpCtx.getImageData(0, 0, 1, 1);
            const color = [
                imgData.data[0],
                imgData.data[1],
                imgData.data[2]
            ];
            const lightenColor = color.map(v => Math.min(v + 30, 255));
            lightenColor.push(imgData.data[3] / 255);
            const darkenColor = color.map(v => Math.max(v - 10, 0));
            darkenColor.push(imgData.data[3] / 255);

            this.iceState = {
                lightenColor: 'rgba(' + lightenColor.join(',') + ')',
                darkenColor: 'rgba(' + darkenColor.join(',') + ')',
                velocity: this.options.iceVelocity,
                moveRangeStart: -130,
                moveRangeEnd: this.options.realWidth + 120,
            };

            this.iceState.penguinImage = new Image;
            this.iceState.penguinImage.src = penguinData;
        }

        // Shake with mouse
        if (this.options.handleMouse) {
            canvas.addEventListener('mousedown', this.handleCollision.bind(this));
            canvas.addEventListener('touchstart', this.handleCollision.bind(this));
            this.mouseShakeState = {
                direction: 1,
                startTime: 0,
                time: 0,
                animating: false,
            };
            this.randomWordState = {
                word: '',
                startTime: 0,
                time: 0,
                opacity: 0,
                shown: false,
            };
        }

        this.startTime = Date.now();
        raindropsAnimationTick(this);
    },

    updateSprings: function (time) {
        for (let i = 0; i < this.springs.length; ++i) {
            const positivePos = time / 150 + i;
            const negativePos = -time / 150 + i;
            this.springs[i] = Math.sin(positivePos / 3) * 4
                + Math.sin(negativePos / 10) * 2 + Math.sin(negativePos / 2);
        }
    },

    renderWaves: function() {
        this.ctx.beginPath();
        this.ctx.moveTo(0, this.options.canvasHeight);
        for (let i = 0; i < this.springs.length; i++) {
            this.ctx.lineTo(i * 6, (this.options.canvasHeight / 2) + this.springs[i]);
        }
        this.ctx.lineTo(this.options.realWidth, this.options.canvasHeight);
        this.ctx.fill();
    },

    renderPenguins: function() {
        if (!this.options.drawPenguins) {
            return;
        }

        // We don't show penguins on smaller screen (e.g. mobile devices).
        if (this.options.realWidth > 300) {
            const iceHeight = this.options.canvasHeight / 2 + 50;

            this.ctx.save();
            this.ctx.translate(this.iceState.position, this.options.canvasHeight - iceHeight);

            if (this.options.handleMouse && this.mouseShakeState.animating)  {
                const frac = Math.PI * this.mouseShakeState.time / 250;
                const extinction = this.mouseShakeState.time / 100 + 8;
                this.ctx.rotate(Math.sin(frac) * this.mouseShakeState.direction / extinction);
            } else {
                if (this.options.shakeIce) {
                    const leftIndex = Math.max(Math.floor((this.iceState.position - 90) / 6), 0);
                    const rightIndex = Math.min(Math.ceil(
                        (this.iceState.position + 150) / 6), this.springs.length - 1);

                    let diff = 0;
                    if ((leftIndex >= 0 && leftIndex < this.springs.length) &&
                        (rightIndex >= 0 && rightIndex < this.springs.length)) {
                        diff = this.springs[leftIndex] - this.springs[rightIndex];
                    }

                    this.ctx.rotate(diff / 130);
                }
            }

            this.ctx.fillStyle = this.options.iceColor;
            this.ctx.beginPath();
            this.ctx.moveTo(-90, 60);
            this.ctx.lineTo(-80, 10);
            this.ctx.lineTo(110, 15);
            this.ctx.lineTo(80, 80);
            this.ctx.fill();

            this.ctx.fillStyle = this.iceState.lighenColor;
            this.ctx.beginPath();
            this.ctx.moveTo(-80, 10);
            this.ctx.lineTo(-20, 0);
            this.ctx.lineTo(130, 5);
            this.ctx.lineTo(110, 15);
            this.ctx.fill();

            this.ctx.fillStyle = this.iceState.darkenColor;
            this.ctx.beginPath();
            this.ctx.moveTo(110, 15);
            this.ctx.lineTo(130, 5);
            this.ctx.lineTo(150, 70);
            this.ctx.lineTo(80, 80);
            this.ctx.fill();

            if (this.iceState.velocity > 0) {
                this.ctx.drawImage(this.iceState.penguinImage, 10 - this.iceState.penguinImage.width,
                                  -this.iceState.penguinImage.height + 10);
                if (this.randomWordState.shown) {
                    this.ctx.save();
                    this.ctx.rotate(0.5);
                    this.ctx.fillStyle = this.options.wordColor;
                    this.ctx.globalAlpha = this.randomWordState.opacity;
                    this.ctx.textAlign = 'center';
                    this.ctx.fillText(this.randomWordState.word, 10,
                                      -this.iceState.penguinImage.height + 20);
                    this.ctx.restore();
                }
            } else {
                this.ctx.save();
                this.ctx.scale(-1, 1);
                this.ctx.drawImage(this.iceState.penguinImage, 10 - this.iceState.penguinImage.width,
                                  -this.iceState.penguinImage.height + 10);
                this.ctx.restore();

                if (this.randomWordState.shown) {
                    this.ctx.save();
                    this.ctx.rotate(-0.5);
                    this.ctx.fillStyle = this.options.wordColor;
                    this.ctx.globalAlpha = this.randomWordState.opacity;
                    this.ctx.textAlign = 'center';
                    this.ctx.fillText(this.randomWordState.word, -10,
                                      -this.iceState.penguinImage.height + 20);
                    this.ctx.restore();
                }
            }

            this.ctx.restore();
        }
    },

    manipulatePenguinPosition: function(time) {
        if (this.iceState.velocity > 0) {
            this.iceState.position = (this.iceState.velocity / 30 * time)
                % (this.options.realWidth + 270) - 150;
        } else {
            this.iceState.position = (this.iceState.velocity / 30 * time)
                % (this.options.realWidth + 270) + this.options.realWidth + 120;
        }
    },

    isColliding: function(x, y, points) {
        // Crossing number algorithm
        let crossing = 0;
        for (let i = 1; i < points.length; ++i) {
            const p0 = [points[i - 1][0], points[i - 1][1]];
            const p1 = [points[i][0], points[i][1]];
            if (i > 1) {
                this.ctx.lineTo(p1[0], p1[1]);
            }
            if ((p0[1] <= y && p1[1] > y) ||
                (p0[1] > y && p1[1] <= y)) {
                const vt = (y - p0[1]) / (p1[1] - p0[1]);
                if (x < (p0[0] + (vt * (p1[0] - p0[0])))) {
                    ++crossing;
                }
            }
        }

        return crossing % 2 == 1;
    },

    handleCollision: function(event) {
        const x = event.offsetX;
        const y = event.offsetY;

        const iceHeight = this.options.canvasHeight / 2 + 50;

        let penguinPoints;
        if (this.options.iceMoveFraction > 0) {
            penguinPoints = [[10 - this.iceState.penguinImage.width, -this.iceState.penguinImage.height + 10],
                             [10, -this.iceState.penguinImage.height + 10],
                             [10, 10],
                             [10 - this.iceState.penguinImage.width, 10],
                             [10 - this.iceState.penguinImage.width, -this.iceState.penguinImage.height + 10]];
        } else {
            penguinPoints = [[-10 + this.iceState.penguinImage.width, -this.iceState.penguinImage.height + 10],
                             [-10, -this.iceState.penguinImage.height + 10],
                             [-10, 10],
                             [-10 + this.iceState.penguinImage.width, 10],
                             [-10 + this.iceState.penguinImage.width, -this.iceState.penguinImage.height + 10]];
        }
        const realPenguinPoints = penguinPoints.map(coord =>
            [coord[0] + this.iceState.position, coord[1] + this.options.canvasHeight - iceHeight]);
        if (this.isColliding(x, y, realPenguinPoints)) {
            this.showRandomWord(Date.now());
            return;
        }

        const icePoints = [[-90, 60], [-80, 10], [-20, 0], [130, 5], [150, 70], [80, 80], [-90, 60]];
        const realIcePoints = icePoints.map(coord =>
            [coord[0] + this.iceState.position, coord[1] + this.options.canvasHeight - iceHeight])

        if (this.isColliding(x, y, realIcePoints)) {
            const direction = x > this.iceState.position ? 1 : -1;
            this.animateShake(direction, Date.now());
        }
    },

    animateShake: function(direction, time) {
        this.mouseShakeState.startTime = time;
        this.mouseShakeState.time = 0;
        this.mouseShakeState.direction = direction;
        this.mouseShakeState.animating = true;
    },

    showRandomWord: function(time) {
        this.randomWordState.word = this.options.randomWords[(Math.random()
            * this.options.randomWords.length) >> 0];
        this.randomWordState.opacity = 0;
        this.randomWordState.startTime = time;
        this.randomWordState.time = 0;
        this.randomWordState.shown = true;
    },

    updateMouseInteractionState: function(realTime) {
        if (this.randomWordState.shown) {
            this.randomWordState.time = realTime - this.randomWordState.startTime;

            if (this.randomWordState.time > 1000) {
                this.randomWordState.shown = false;
            }

            this.randomWordState.opacity = Math.min(1 - Math.abs(
                this.randomWordState.time - 500) / 1200, 1);
        }

        if (this.mouseShakeState.animating) {
            if (this.mouseShakeState.time > 2000) {
                this.mouseShakeState.animating = false;
            }
            this.mouseShakeState.time = realTime - this.mouseShakeState.startTime;
        }
    },
});

const raindropsAnimationTick = (drop) => {
    const realTime = Date.now();
    const time = realTime - drop.startTime;

    drop.ctx.clearRect(0, 0, drop.options.realWidth, drop.options.canvasHeight);
    drop.updateSprings(time);
    drop.updateMouseInteractionState(realTime);
    drop.renderWaves();
    drop.renderPenguins();
    drop.manipulatePenguinPosition(time);

    requestAnimationFrame(() => {
        raindropsAnimationTick(drop);
    });
};

// Penguin image is taken from https://www.illust-ai.com/single.php?c=00000422
const penguinData = 'data:image/webp;base64,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'