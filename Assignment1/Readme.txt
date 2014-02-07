Space Invaders:
The website implements the classic arcade game - Space Invaders.

How it works:
	The website uses a canvas working in harmony with the Foundation framework. Even though the Foundation framework
is used to implement the basic looks of things, the other functionality regarding it remains unimplemented.
	The game functions completely on the canvas itself. As far as the HTML side of things are concerned, it is very minimal
and is used only to create the standard structure of the document. CSS is used to style the canvas and apart from that, the css
file has no other use.
	The core of the game is implemented entirely in JavaScript (with bits of JQuery).

Implementation details (datastructures and classes/functions):
There are four main classes (implemented as functions) - Board, CanonShip, Bullet and Aliens. 
	The Board is the main controlling class. It implements the initialization of the game, i.e., setting up the canvas and the context. Along with that, it also has counters for keeping track of score and levels. It also has the function 'run', which instantiates the Ship, the Bullet and the Aliens.

	The CanonShip is responsible for controlling the Canon on the canvas. It keeps track of its position, and the moving direction if need be. Apart from that, it also has a function that's responsible for drawing the ship on the canvas, so the player can see the ship actually moving. The way the drawing is implemented would be explained slightly later.

	The Bullet is responsible for managing the canon's bullets. The function (class) keeps track of the bullet position along with the speed with which its supposed to move. It also has some other variable to determine if a new bullet can/should be spawned or not. It also has a similar draw function as CanonShip's which is used to draw the moving bullet when needed.

	The last class/function which is used is the Aliens. It uses a double array to keep track of all the aliens. '1' represents an alive one while '0' represents a dead one. It has all the necessary variables to determine how the aliens should move around the screen and how they should move down too. Apart from that, it has a few functions which initializes the double array of aliens and a similar draw function as the other classes. It also has a shift function which determines how the aliens move whenever they need to.

The way the drawing (animation) works is that it uses a timer which tells the canvas when to draw things on it. It calls the respective draw functions from each class to determine where the ship, bullet and aliens are. Whenever it goes ahead with drawing, it clears the canvas to start afresh.

Lastly, it uses the onload function of JQuery to determine when the game should be loaded. It also uses two other functions to react ot key presses.

