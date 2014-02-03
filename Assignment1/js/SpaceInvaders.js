
// Trial function. Will implement the actual game later
function drawTriangle() {
	var canvas = document.getElementById("mainScreen");
	var context = canvas.getContext("2d");
	alert("Hello");
	context.strokeStyle = "blue";

	context.movetTo(250, 50);
	context.lineTo(50,250);
	context.lineTo(450, 250);
	context.closePath();

	context.stroke();
}
