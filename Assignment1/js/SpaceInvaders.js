// The function (class) that initializes the game
var Board = function(){
    this.canvas = document.getElementById("mainCanvas");
    this.context = this.canvas.getContext("2d");
    
    this.width = 800;
    this.height = 600;

    this.level = 1;
};

var theBoard = new Board();
var theShip;
var theBullet;
var theAliens;

var CanonShip = function() {
    this.x = 380;
    this.y = 580;

    this.width = 20;
    this.height = 20;

    // movement flags
    this.movingRight = false;
    this.movingLeft = false;
    
    // this.image = new Image();
    // img.src = "";
};

CanonShip.prototype.drawShip = function() {
	// moving the ship before drawing
	// could make this a shift function too?
	if(this.movingRight) {
		if (theShip.x + 7 <= 780)
    		theShip.x += 7;
	}
	else if(this.movingLeft) {
		if (theShip.x - 7 >= 0)
    		theShip.x -= 7;
	}
	theBoard.context.fillStyle = "green"
    theBoard.context.fillRect(this.x, this.y, this.width, this.height);
};

var Bullet = function() {
	this.width = 2;
	this.height = 10;
	this.x;
	this.y;

	this.speed = 10;
	this.amIAlive = false;
	this.spam = false;
};

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

var Aliens = function() {
	// the 2d array for all aliens
	this.alienPos = new Array();
	// dimension stuff for aliens
	this.x = 160;
	this.y = 50;
	this.width = 20;
    this.height = 20;
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

Aliens.prototype.initAliens = function() {
	for (var i = 0; i < 5; i++) {
		this.alienPos[i] = [1,1,1,1,1,1,1,1,1,1];
	};
};

Aliens.prototype.drawAliens = function() {
	theBoard.context.fillStyle = "blue";
	var shiftX = 0, shiftY = 0;
	for (var i = 0; i < 5; i++) {
		shiftX = 0;
		for (var j = 0; j < 10; j++) {
			// making sure that aliens are drawn correctly
			// move this check to shift()
			if(this.alienPos[i][j] == 1)
 				theBoard.context.fillRect(this.x + shiftX, this.y + shiftY, this.width, this.height);
 			shiftX += 50;
		};
		shiftY += 40;
	};
};

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
		if(this.x + theBoard.level + 450 < 780) {
			this.x += theBoard.level;
		}
		else {
			this.reachedRightBoundary = true;
		}
	}
	else if (!this.movingRight && this.movingLeft) {
		if (this.x - theBoard.level > 0) {
			this.x -= theBoard.level;
		}
		else {
			this.reachedLeftBoundary = true;
		}
	}

	// determine if shifting down is required
	if(this.shiftDown) {
		this.shiftDown = false;
		if(this.y + 200 < 580)
			this.y += 20;
		else
			this.success = true;
	}
}

// unimplemented
function checkCollision() {
	// first checking if the bullet is in the big square
	if (theBullet.x > theAliens.x 
		&& theBullet.y > theAliens.y) {

	}
}

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

function redraw() {
	clearScreen();
	theShip.drawShip();
	theBullet.drawBullet();
	theAliens.drawAliens();
	theAliens.shift();
	// the aliens reached the bottom of the screen
	if (theAliens.success) {
		alert("Game Over!");
		location.reload();
	}
};

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
		theBullet.spam = false;
	}
});

window.onload = function() {
	theBoard.run();
	setInterval(redraw, 20);
};