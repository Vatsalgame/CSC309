
<!DOCTYPE html>

<html>
	<head>
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

		.indicator{
			margin-top: 10px;
			position: absolute;
			display: none;
			background-color: red;
			border-radius: 100px;
			border: 4px solid white;
			padding: 20px;
		}


	</style>

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
	<script>

		var otherUser = "<?= $otherUser->login ?>";
		var user = "<?= $user->login ?>";
		var status = "<?= $status ?>";
		
		$(function(){
			$('body').everyTime(2000,function(){
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
				});



			theArray = [[0, 0, 0, 0, 0, 0, 0],
									[0, 0, 0, 0, 0, 0, 0],
									[0, 0, 0, 0, 0, 0, 0],
									[0, 0, 0, 0, 0, 0, 0],
									[0, 0, 0, 0, 0, 0, 0],
									[0, 0, 0, 0, 0, 0, 0]]

			setInterval(function(){
				// ajax call to update the array
				for (var i = 0; i < theArray.length; i++) {
					for (var j = 0; j < theArray[i].length; j++) {
						if (theArray[i][j] == -1){
							targetId = '#cell' + i + '' + j;
							$(targetId).removeClass('cell-empty').addClass('cell-opp');
						}
					};
				};
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

			$('.indicator').css('left', $('.board').position().left);

			$('.cell').hover(
				function(e){
					$('.indicator').css({'left': $(this).position().left, 'display': 'inline-block'});
					hoverCellColor($(this), true);
				}, 
				function(e){
					$('.indicator').css('display', 'none');
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
				col = getCellCol($(this));
				target = whichCell(col, theArray);
				if(target){
					theArray[target.row][target.col] = 1
					$(target.targetId).removeClass('cell-empty').addClass('cell-your');
					if(target.row-1 >= 0)
						hoverCellColor($('#cell' + (target.row-1) + '' + target.col), true);
				}
			});
		});
	
	</script>
	</head> 
<body>  
	<h1>Game Area</h1>

	<div>
	Hello <?= $user->fullName() ?>  <?= anchor('account/logout','(Logout)') ?>  
	</div>
	
	<div id='status'> 
	<?php 
		if ($status == "playing")
			echo "Playing " . $otherUser->login;
		else
			echo "Wating on " . $otherUser->login;
	?>
	</div>
	
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


<span class="indicator"></span>
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
	<tr>
		<td class="cell cell-empty" id="cell10"></td>
		<td class="cell cell-empty" id="cell11"></td>
		<td class="cell cell-empty" id="cell12"></td>
		<td class="cell cell-empty" id="cell13"></td>
		<td class="cell cell-empty" id="cell14"></td>
		<td class="cell cell-empty" id="cell15"></td>
		<td class="cell cell-empty" id="cell16"></td>
	</tr>
	<tr>
		<td class="cell cell-empty" id="cell20"></td>
		<td class="cell cell-empty" id="cell21"></td>
		<td class="cell cell-empty" id="cell22"></td>
		<td class="cell cell-empty" id="cell23"></td>
		<td class="cell cell-empty" id="cell24"></td>
		<td class="cell cell-empty" id="cell25"></td>
		<td class="cell cell-empty" id="cell26"></td>
	</tr>
	<tr>
		<td class="cell cell-empty" id="cell30"></td>
		<td class="cell cell-empty" id="cell31"></td>
		<td class="cell cell-empty" id="cell32"></td>
		<td class="cell cell-empty" id="cell33"></td>
		<td class="cell cell-empty" id="cell34"></td>
		<td class="cell cell-empty" id="cell35"></td>
		<td class="cell cell-empty" id="cell36"></td>
	</tr>
	<tr>
		<td class="cell cell-empty" id="cell40"></td>
		<td class="cell cell-empty" id="cell41"></td>
		<td class="cell cell-empty" id="cell42"></td>
		<td class="cell cell-empty" id="cell43"></td>
		<td class="cell cell-empty" id="cell44"></td>
		<td class="cell cell-empty" id="cell45"></td>
		<td class="cell cell-empty" id="cell46"></td>
	</tr>
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
	
	
	
	
</body>

</html>

