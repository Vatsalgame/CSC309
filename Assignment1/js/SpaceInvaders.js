// The main board (screen) for the game
var Board = function(){
    this.canvas = document.getElementById("mainCanvas");
    this.context = this.canvas.getContext("2d");
    
    this.width = 800;
    this.height = 600;

    this.level = 1;
    this.score = 0;
};

// all global variables
var theBoard = new Board();
var theShip;
var theBullet;
var theAliens;

// the user controlled ship
var CanonShip = function() {
    this.x = 380;
    this.y = 580;

    this.width = 50;
    this.height = 20;

    // movement flags
    this.movingRight = false;
    this.movingLeft = false;
    
    // this.image = new Image();
    // img.src = "";
};

// function to draw the ship
CanonShip.prototype.drawShip = function() {
	// moving the ship before drawing
	// could make this a shift function too?
	if(this.movingRight) {
		if (theShip.x + 7 <= 800 - this.width)
    		theShip.x += 7;
	}
	else if(this.movingLeft) {
		if (theShip.x - 7 >= 0)
    		theShip.x -= 7;
	}
	theBoard.context.fillStyle = "green";
    theBoard.context.fillRect(this.x, this.y, this.width, this.height);
};

// the bullet (generally shot from the ship)
var Bullet = function() {
	this.width = 2;
	this.height = 10;
	this.x;
	this.y;

	this.speed = 10;
	this.amIAlive = false;
	this.spam = false;
};

// function to draw the moving bullet
Bullet.prototype.drawBullet = function() {
	if (this.y < -10) { 
		// outside screen
		this.amIAlive = false;
	}
	if (this.amIAlive) {
		this.y -= this.speed;
		if(this.y < -10 && this.spam) {
			theBullet.x = theShip.x + (theShip.width/2);
    		theBullet.y = theShip.y;
		}
		theBoard.context.fillStyle = "red"
	    theBoard.context.fillRect(this.x, this.y, this.width, this.height);
	}
	if (!this.amIAlive) {
		theBullet.x = theShip.x + (theShip.width/2);
    	theBullet.y = theShip.y;
	}
};

// all the aliens!
var Aliens = function() {
	// the 2d array for all aliens
	this.alienPos = new Array();
	// dimension stuff for aliens
	this.x = 160;
	this.y = 50;
	this.width = 20;
    this.height = 20;
    // if aliens in a row or a column get destroyed, modifiy the shifting parameters
    this.overallHeight = 200;
    this.leftBoundary = 0;
    this.rightBoundary = 450;
    // the array to keep track of aliens in a column
    this.alienColCount = [5,5,5,5,5,5,5,5,5,5];
    this.alienRowCount = [10, 10, 10, 10, 10];
    // keeping a total count to quickly determine
    // if a level's over
    this.totalAlienCount = 50;
    // vars to determine which is the last left or
    // right column (in all aliens in a row or col get destroyed)
    this.leftCol = 0;
    this.rightCol = 9;
    this.lastRow = 4;

    // flags for movement
    this.movingLeft = false;
    // start the game by moving right
    this.movingRight = true;
    this.shiftDown = false;
    this.reachedRightBoundary = false;
    this.reachedLeftBoundary = false;
    // this flas determines if the aliens reached the
    // botttom and won the game
    this.success = false;
};

// function to initialize the aliens
Aliens.prototype.initAliens = function() {
	for (var i = 0; i < 5; i++) {
		this.alienPos[i] = [1,1,1,1,1,1,1,1,1,1];
	};
};

// function to draw the shifting aliens
Aliens.prototype.drawAliens = function() {
	theBoard.context.fillStyle = "blue";
	var shiftX = 0, shiftY = 0;
	for (var i = 0; i < 5; i++) {
		shiftX = 0;
		for (var j = 0; j < 10; j++) {
			// making sure that aliens are drawn correctly
			// move this check to shift()
			if(this.alienPos[i][j] == 1)
				// checking bullet collision
				if(theBullet.x >= this.x + shiftX && theBullet.x <= this.x + shiftX + this.width) {
					if(theBullet.y >= this.y + shiftY && theBullet.y <= this.y + shiftY + this.height) {
						// destroying the alien
						this.alienPos[i][j] = 0;
						// decreasing alien count
						this.alienColCount[j] -= 1;
						this.alienRowCount[i]--;
						if (this.alienRowCount[this.lastRow] == 0){
							this.lastRow--;
							this.overallHeight -= 40;
						}
						if (this.alienColCount[this.leftCol] == 0){
							this.leftCol++;
							this.leftBoundary += 50;
						}
						if (this.alienColCount[this.rightCol] == 0){
							this.rightCol--;
							this.rightBoundary -= 50;
						}
						this.totalAlienCount -= 1;
						// increasing the score
						theBoard.score += 1;
						// destroying the bullet
						theBullet.amIAlive = false;
						theBullet.spam = false;
					}
				}
				// checking to make sure that the alien is still alive
				if(this.alienPos[i][j] == 1)
 					theBoard.context.fillRect(this.x + shiftX, this.y + shiftY, this.width, this.height);
 			shiftX += 50;
		};
		shiftY += 40;
	};
};

// function to actually shift the aliens
Aliens.prototype.shift = function() {
	// determine if we need to switch movement direction
	if (this.reachedRightBoundary) {
		this.reachedRightBoundary = false;
		this.movingLeft = true;
		this.movingRight = false;
		this.shiftDown = true;
	}

	else if (this.reachedLeftBoundary) {
		this.reachedLeftBoundary = false;
		this.movingLeft = false;
		this.movingRight = true;
		this.shiftDown = true;
	}

	// determine which side to move towards
	if (this.movingRight && !this.movingLeft) {
		// make sure that all the aliens can be drawn
		if(this.x + theBoard.level + this.rightBoundary < 780) {
			this.x += theBoard.level;
		}
		else {
			this.reachedRightBoundary = true;
		}
	}
	else if (!this.movingRight && this.movingLeft) {
		if (this.x - theBoard.level + this.leftBoundary > 0) {
			this.x -= theBoard.level;
		}
		else {
			this.reachedLeftBoundary = true;
		}
	}

	// determine if shifting down is required
	if(this.shiftDown) {
		this.shiftDown = false;
		if(this.y + this.overallHeight < 580)
			this.y += 20;
		else if(this.totalAlienCount > 0)
			this.success = true;
	}
}

// function to display the score
function displayScore() {
	theBoard.context.fillStyle = "green";
	theBoard.context.font = "bold 24px Times";
	theBoard.context.fillText("Score: " + theBoard.score, 7, 22);
	theBoard.context.fillText("Level: " + theBoard.level, 700, 22);
}

// function to run the game
Board.prototype.run = function(){
    theShip = new CanonShip();
    theBullet = new Bullet();
    theAliens = new Aliens();
    theAliens.initAliens();
    redraw();   
};


function clearScreen() {
	theBoard.context.clearRect(0, 0, 800, 600);
};

// function that is called after every X interval
// redraws on the canvas
function redraw() {
	clearScreen();
	displayScore();
	theShip.drawShip();
	theBullet.drawBullet();
	theAliens.drawAliens();
	theAliens.shift();
	// the aliens reached the bottom of the screen
	if (theAliens.success) {
		alert("Game Over!");
		location.reload();
	}
	if (theAliens.totalAlienCount == 0) {
		alert("Next Level?");		
		theBoard.level += 1;
		theBoard.run();
	}
};

// function to react to key presses
$(document).keydown(function(e){
	// right arrow
    if (e.keyCode == 39) {
    	theShip.movingLeft = false;
    	theShip.movingRight = true;
   		return false;
    }
    // left arrow
    else if (e.keyCode == 37) {
    	theShip.movingRight = false;
    	theShip.movingLeft = true;
       	return false;
    }
    // space
    else if (e.keyCode == 32) {
    	if (!theBullet.amIAlive) {
	    	theBullet.amIAlive = true;
	    }
	    theBullet.spam = true;
       	return false;
    }
    else {
    	return true;
    }
});

$(document).keyup(function(e) {
	// right arrow
	if (e.keyCode == 39) {
		theShip.movingRight = false;
	}
	// left arrow
	else if (e.keyCode == 37) {
		theShip.movingLeft = false;
	}
	else if (e.keyCode == 32) {
		this.amIAlive = false;
		theBullet.spam = false;
	}
});

// runs the game when page is loaded
window.onload = function() {
	theBoard.run();
	setInterval(redraw, 20);
};