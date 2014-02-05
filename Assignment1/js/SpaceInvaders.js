// The function (class) that initializes the game
var Board = function(){
    this.canvas = document.getElementById("mainCanvas");
    this.context = this.canvas.getContext("2d");
    
    this.width = 800;
    this.height = 600;

    this.level = 1;
};

var board = new Board();

var CanonShip = function() {
    this.x = 380;
    this.y = 580;
    this.lives = 3;
    
    // this.image = new Image();
    // img.src = "";
    board.context.fillStyle = "green"
    board.context.fillRect(this.x, this.y, 20, 20);
    
};

Board.prototype.run = function(){
    theShip = new CanonShip();   
};

window.onload = function() {
	board.run();
}