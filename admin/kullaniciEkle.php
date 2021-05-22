<?php
	session_start();
?>
<html>
	<head>
		<meta charset="utf-8">
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
		<link href="css/bootstrap.min.css" rel="stylesheet"/>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	</head>

	<body>
		<div class="container col-md-4"><br><br>
			<div class="row align-content-center justify-content-center">
                <form name="add_name" id="add_name">
					<div class="table">
                        <h3>Yeni Kullanıcı Ekle</h3>
						<table class="table table-bordered" id="dynamic_field">
							<tr>
								<td>
									<input type="text" name="txtKadi" class="form-control" placeholder="Kullanıcı adı" required/>
								</td>
							</tr>
							<tr>
								<td>
									<input type="text" name="kota" class="form-control" placeholder="Sms/Mail Kotası"required/>
								</td>
							</tr>
							<tr>
								<td>
									<input type="password" name="txtParola" class="form-control" placeholder="Parola" required/>
								</td>
							</tr>
							<tr>
								<td>
									<input type="password" name="txtParolaTekrar" class="form-control" placeholder="Parola Tekrar" required/>
								</td>
							</tr>
							<tr>
								<td><input type="text" name="name[]" placeholder="Grup Adı" class="form-control name_list" /></td>
								<td><button type="button" name="add" id="add" class="btn btn-success">+</button></td>
							</tr>
						</table>
						<div class="text-center">
							<table class="table">
								<tr>
									<input type="button" name="submit" id="submit" class="btn btn-info btn-block" value="Kaydet" /><br>
								</tr>
								<tr>
									<a href="giris.php" class="btn btn-danger">Geri Dön</a>
								</tr>
							</table>
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>

<script>
$(document).ready(function(){
	var i=1;
	$('#add').click(function(){
		i++;
		$('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Grup Adı" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">x</button></td></tr>');
	});
	
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
	
	$('#submit').click(function(){		
		$.ajax({
			url:"ekle.php",
			method:"POST",
			data:$('#add_name').serialize(),
			success:function(data)
			{
				alert(data);
				$('#add_name')[0].reset();
			}
		});
	});
	
});
</script>