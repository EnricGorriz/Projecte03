<?php
session_start();
if(isset($_SESSION['error'])) $error = $_SESSION['error'];
if(isset($_SESSION['validarse'])) $validarse = $_SESSION['validarse'];
session_destroy();
?>
<!DOCTYPE html>
<html >
	<head>
		<meta charset="UTF-8">
		<title>Formulario LOGIN</title>
		<link rel="stylesheet" href="css/style.css">
		
		<script src="js/index.js"></script>
	</head>
	<body>
		<form action="reservas.php" method="POST">
			<div class="container">
				<div class="profile">
				<?php
					if(isset($error)){
						echo "Usuario o Contrasenya Incorrecto<br/><br/><br/>";
					}
					if(isset($validarse)){
						echo "Antes de entrar debes validate<br/><br/><br/>";
					}
				?>
					<img class="profile__avatar" id="toggleProfile" src="images/logoSoloIcono.png" alt="Avatar" onclick="muestra2();"/> 
					<div class="profile__form">
						<div class="profile__fields">
							<div class="field">
								<input type="text" id="fieldUser" class="input" name="mail" value="" size="10" maxlength="60" required pattern=.*\S.* />
								<label for="fieldUser" class="label">Correo</label>
							</div>
							<div class="field">
								<input type="password" id="fieldPassword" class="input" name="contraseña" value="" size="10" maxlength="10" required pattern=.*\S.* />
								<label for="fieldPassword" class="label">Contraseña</label>
							</div>
							<input type="hidden" name="login"/>
							<div class="profile__footer">
								<input type="submit" class="btn" value="Entrar"/>
								</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
