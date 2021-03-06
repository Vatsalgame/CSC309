
<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>Connect4 | MainPage</title>
    	<link rel="stylesheet" href="<?php echo base_url("css/foundation.min.css"); ?>" />
    	<script src="<?php echo base_url("js/vendor/modernizr.js"); ?>"></script>
    	<script src="<?php echo base_url("js/vendor/jquery.js"); ?>"></script>
	<style type="text/css">
		.board{
			background-color: #06F;
			border: thin solid #ccc;
			margin: 60px auto;
		}

		.cell{
			border-radius: 100px;
			border: 4px solid #ddd;
			padding: 20px;
		}

		.cell-hover{
			background-color: #fbb;
		}

		.cell-empty{
			background-color: white;
		}

		.cell-your{
			background-color: red;
		}

		.cell-opp{
			background-color: yellow;
		}

		#indicator{
			margin-top: 10px;
			position: absolute;
			display: none;
		}

		.legend{
			border-radius: 100px;
			border: 4px solid white;
			padding: 20px;
		}

		.legend-your{
			background-color: red;
		}

		.legend-opp{
			background-color: yellow;
		}


	</style>

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
	<script>

		var otherUser = "<?= $otherUser->login ?>";
		var user = "<?= $user->login ?>";
		var user_id = "<?= $user->id ?>";
		var status = "<?= $status ?>";
		
		var yourPiece = user_id;
		
		$(function(){
			/*$('body').everyTime(2000,function(){
					if (status == 'waiting') {
						$.getJSON('<?= base_url() ?>arcade/checkInvitation',function(data, text, jqZHR){
								if (data && data.status=='rejected') {
									alert("Sorry, your invitation to play was declined!");
									window.location.href = '<?= base_url() ?>arcade/index';
								}
								if (data && data.status=='accepted') {
									status = 'playing';
									$('#status').html('Playing ' + otherUser);
								}
								
						});
					}
					var url = "<?= base_url() ?>board/getMsg";
					$.getJSON(url, function (data,text,jqXHR){
						if (data && data.status=='success') {
							var conversation = $('[name=conversation]').val();
							var msg = data.message;
							if (msg.length > 0)
								$('[name=conversation]').val(conversation + "\n" + otherUser + ": " + msg);
						}
					});
			});

			$('form').submit(function(){
				var arguments = $(this).serialize();
				var url = "<?= base_url() ?>board/postMsg";
				$.post(url,arguments, function (data,textStatus,jqXHR){
						var conversation = $('[name=conversation]').val();
						var msg = $('[name=msg]').val();
						$('[name=conversation]').val(conversation + "\n" + user + ": " + msg);
						});
				return false;
				});*/



			theArray = null;
			user_turn = null;

			function successFunc(){
				for (var i = 0; i < theArray.length; i++) {
					for (var j = 0; j < theArray[i].length; j++) {
						if (theArray[i][j] != yourPiece && theArray[i][j] != 0){
							targetId = '#cell' + i + '' + j;
							$(targetId).removeClass('cell-empty').addClass('cell-opp');
						}
					}
				}
			};

			function getBoard(link){
				$.getJSON(link, function(data){
					theArray = data[0];
					user_turn = data[1];
					winner = data[2];
					// console.log(winner);
					$("#whose-turn").html(user_turn);
					if(user == user_turn)
						successFunc();

					if(winner){
						if (winner == -2){
							window.clearInterval(intervalId);
							alert('Game Tied!');
							window.location.assign("<?= base_url() ?>");
						}
						else if(winner == -4){}
						else if(winner == yourPiece){
							window.clearInterval(intervalId);
							alert('You won!');
							window.location.assign("<?= base_url() ?>");
						}
						else{
							window.clearInterval(intervalId);
							alert(otherUser + ' won!');
							window.location.assign("<?= base_url() ?>");
						}
					}
				});
			}

			// getBoard("<?= base_url() ?>board/getBoard");

			var intervalId = setInterval(function(){
				getBoard("<?= base_url() ?>board/getBoard");
				//check other's win status
			}, 20);


			function whichCell(col, theArray){
				for (var row = theArray.length - 1; row >= 0; row--) {
					if (theArray[row][col] == 0){
						return {
							'row': row,
							'col': col,
							'targetId': '#cell' + row + '' + col
						};
					};
				}
				return null;
			}

			$('#indicator').css('left', $('.board').position().left);

			$('.cell').hover(
				function(e){
					$('#indicator').css({'left': $(this).position().left, 'display': 'inline-block'});
					hoverCellColor($(this), true);
				}, 
				function(e){
					$('#indicator').css('display', 'none');
					hoverCellColor($(this), false);
				});

			function getCellCol(cell){
				thisId = cell.attr('id');
				return thisId.charAt(thisId.length-1);
			}

			function hoverCellColor(cell, color){
				col = getCellCol(cell);
				try{
					targetId = whichCell(col, theArray).targetId;
					if (color)
						$(targetId).removeClass('cell-empty').addClass('cell-hover');
					else
						$(targetId).removeClass('cell-hover').addClass('cell-empty');
				} catch(E){}
			}

			$('.cell').click(function(){
				if (user == user_turn) {
					col = getCellCol($(this));
					target = whichCell(col, theArray);
					if(target){
						theArray[target.row][target.col] = yourPiece;
						$(target.targetId).removeClass('cell-empty').addClass('cell-your');
						if(target.row-1 >= 0){
							hoverCellColor($('#cell' + (target.row-1) + '' + target.col), true);
						}
						user_turn = otherUser;
						$.post("<?= base_url() ?>board/postBoard", 
							{'array': theArray, 'username': otherUser}, 
							function(data){
								// var winner = data.winner;
								// console.log(winner);
								// if(winner){
								// 	if (winner == -2){
								// 		window.clearInterval(intervalId);
								// 		alert('Game Tied!');
								// 		window.location.assign("<?= base_url() ?>");
								// 	}
								// 	else if(winner == -4){}
								// 	else if(winner == yourPiece){
								// 		window.clearInterval(intervalId);
								// 		alert('You won!');
								// 		window.location.assign("<?= base_url() ?>");
								// 	}
								// 	else{}
								// }
							}, 'json');
					}
					else{
						alert("You can't place a piece in this column");
					}
				} 
				else{
					alert("It's not your turn. Wait until the other player plays a move.");
				}
			});
		});
	
	</script>
	</head> 
<body>  
	<div class="row">
			<h1><center>Game Area</center></h1>

			<div class="right">
				<div>
					<h4> Hello <?= $user->fullName() ?>
				</div>
				<?= anchor('account/logout','Logout', 'class="button"') ?> </h4>
			</div>
			
			<div id='status'> 
				<h4>
				Reference
				</h4>
			</div>
		<!-- 	
		<?php 

			$textareaData = array(
		          'name' => 'conversation', 'readonly' => 'readonly',
		        );

			$inputData = array('name' => 'msg', 'size' => 28);

			echo form_textarea($textareaData);
			
			echo form_open();
			echo form_input($inputData);
			echo form_submit('Send','Send');
			echo form_close();
			
		?>
		 -->

		<table style="background-color: #ccc">
			<tr>
				<td>Your color:</td>
				<td><b style="color: red">RED</b></td>
			</tr>
			<tr>
				<td><?= $otherUser->login ?>'s color:</span></td>
				<td><b style="color: yellow">YELLOW</b></td>
			</tr>
		</table>

		<div><h5> It's <b id="whose-turn"></b> turn </h5></div>

		<span class="legend legend-your" id="indicator"></span>
		<table class="board">
			<tr>
				<td class="cell cell-empty" id="cell00"></td>
				<td class="cell cell-empty" id="cell01"></td>
				<td class="cell cell-empty" id="cell02"></td>
				<td class="cell cell-empty" id="cell03"></td>
				<td class="cell cell-empty" id="cell04"></td>
				<td class="cell cell-empty" id="cell05"></td>
				<td class="cell cell-empty" id="cell06"></td>
			</tr>
			<tr></tr>
			<tr>
				<td class="cell cell-empty" id="cell10"></td>
				<td class="cell cell-empty" id="cell11"></td>
				<td class="cell cell-empty" id="cell12"></td>
				<td class="cell cell-empty" id="cell13"></td>
				<td class="cell cell-empty" id="cell14"></td>
				<td class="cell cell-empty" id="cell15"></td>
				<td class="cell cell-empty" id="cell16"></td>
			</tr>
			<tr></tr>
			<tr>
				<td class="cell cell-empty" id="cell20"></td>
				<td class="cell cell-empty" id="cell21"></td>
				<td class="cell cell-empty" id="cell22"></td>
				<td class="cell cell-empty" id="cell23"></td>
				<td class="cell cell-empty" id="cell24"></td>
				<td class="cell cell-empty" id="cell25"></td>
				<td class="cell cell-empty" id="cell26"></td>
			</tr>
			<tr></tr>
			<tr>
				<td class="cell cell-empty" id="cell30"></td>
				<td class="cell cell-empty" id="cell31"></td>
				<td class="cell cell-empty" id="cell32"></td>
				<td class="cell cell-empty" id="cell33"></td>
				<td class="cell cell-empty" id="cell34"></td>
				<td class="cell cell-empty" id="cell35"></td>
				<td class="cell cell-empty" id="cell36"></td>
			</tr>
			<tr></tr>
			<tr>
				<td class="cell cell-empty" id="cell40"></td>
				<td class="cell cell-empty" id="cell41"></td>
				<td class="cell cell-empty" id="cell42"></td>
				<td class="cell cell-empty" id="cell43"></td>
				<td class="cell cell-empty" id="cell44"></td>
				<td class="cell cell-empty" id="cell45"></td>
				<td class="cell cell-empty" id="cell46"></td>
			</tr>
			<tr></tr>
			<tr>
				<td class="cell cell-empty" id="cell50"></td>
				<td class="cell cell-empty" id="cell51"></td>
				<td class="cell cell-empty" id="cell52"></td>
				<td class="cell cell-empty" id="cell53"></td>
				<td class="cell cell-empty" id="cell54"></td>
				<td class="cell cell-empty" id="cell55"></td>
				<td class="cell cell-empty" id="cell56"></td>
			</tr>
		</table>
	
	</div>
	
	
</body>

</html>

