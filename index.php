<?php session_start() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Тест PHP Простая авторизация </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<link
		media="screen" rel="stylesheet" type="text/css"
		href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
	>
	<link
		media="screen" rel="stylesheet" type="text/css"
		href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
	>
</head>
<body>

<div class="container">
	<?php if (!empty($_GET['success'])): ?>
		<div class="alert alert-success" role="alert">
			<?php if ($_GET['success'] === 'register') {
				echo 'Вы успешно зрегистрировались';
			} elseif ($_GET['success'] === 'changed') {
				echo 'Данные  изменены успешно';
			} ?>
		</div>
	<?php endif; ?>
	<?php if (!empty($_GET['fail'] === 'auth')): ?>
		<div class="alert alert-danger" role="alert">
			Пользователь с таким паролем не найден
		</div>
	<?php endif; ?>
	<?php if (empty($_GET['register']) && empty($_SESSION['username'])) : ?>
		<form id="auth" method="post" action="action.php">
			<div class="form-group row">
				<label for="Login" class="col-sm-2 col-form-label">Логин</label>
				<div class="col-sm-10">
					<input
						required="required"
						name="login"
						type="text"
						class="form-control"
						id="Login"
						placeholder="Логин"
					>
				</div>
			</div>
			<div class="form-group row">
				<label for="Password" class="col-sm-2 col-form-label">Пароль</label>
				<div class="col-sm-10 input-group">
					<input
						required="required"
						name="pass"
						type="password"
						class="form-control"
						id="Password"
						placeholder="Ваш пароль"
					>
					<div onclick="toggleEye(this)" class="input-group-append">
						<span class="input-group-text">
							<i class="fa fa-eye-slash" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">
					<button name="action" value="auth" type="submit" class="btn btn-primary">Войти</button>
				</div>
				<div class="col-sm-10">
					<a href="?register=1">Зарегистрироваться</a>
				</div>
			</div>
		</form>
	<?php endif; ?>
	<?php if ($_GET['register']): ?>
		<form id="register" method="post" action="action.php">
			<div class="form-group row">
				<label for="Email" class="col-sm-2 col-form-label">Email</label>
				<div class="col-sm-10">
					<input
						name="email"
						required="required"
						type="email"
						class="form-control"
						id="Email"
						placeholder="Email"
					>
				</div>
			</div>
			<div class="form-group row">
				<label for="Password" class="col-sm-2 col-form-label">Пароль</label>
				<div class="col-sm-10 input-group">
					<input
						name="pass"
						required="required"
						type="password"
						class="form-control"
						id="Password"
						placeholder="Ваш пароль"
					>
					<div onclick="toggleEye(this)" class="input-group-append eye">
						<span class="input-group-text">
							<i class="fa fa-eye-slash" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label for="Login" class="col-sm-2 col-form-label">Логин</label>
				<div class="col-sm-10">
					<input
						name="login"
						required="required"
						type="text"
						class="form-control"
						id="Login"
						placeholder="Логин"
					>
				</div>
			</div>
			<div class="form-group row">
				<label for="Fio" class="col-sm-2 col-form-label">Фио</label>
				<div class="col-sm-10">
					<input name="fio" required="required" type="text" id="Fio" class="form-control" placeholder="ФИО"/>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">
					<button name="action" value="register" type="submit" class="btn btn-primary">Регистрация</button>
				</div>
				<div class="col-sm-10">
					<a href="index.php">Авторизоваться</a>
				</div>
			</div>
		</form>
	<?php endif; ?>
	<?php if (!empty($_SESSION['username'])): ?>
		<div class="hello">Здравствуйте, <?= $_SESSION['username'] ?></div>
		<form id="changeData" method="POST" action="action.php">
			<input type="hidden" name="login" value="<?= $_SESSION['username'] ?>">
			<div class="form-group row">
				<label for="Password" class="col-sm-2 col-form-label">Изменить пароль</label>
				<div class="col-sm-10 input-group">
					<input
						name="pass"
						type="password"
						class="form-control"
						id="Password"
						placeholder="Ваш новый пароль"
					/>
					<div onclick="toggleEye(this)" class="input-group-append eye">
						<span class="input-group-text">
							<i class="fa fa-eye-slash" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label for="Fio" class="col-sm-2 col-form-label">Изменить фио</label>
				<div class="col-sm-10">
					<input
						name="fio"
						value="<?= $_SESSION['fio'] ?>"
						type="text"
						id="Fio"
						class="form-control"
						placeholder="ФИО"
						required="required"
					/>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">
					<button name="action" value="changeData" type="submit" class="btn btn-primary">Изменить данные
					</button>
				</div>
				<div class="col-sm-1o">
					<button name="action" value="exit" type="submit" class="btn btn-primary">Выход</button>
				</div>
			</div>
		</form>
	<?php endif; ?>
	<footer>

	</footer>
	<script>
		function toggleEye(el){
          let pass = document.getElementById('Password')
		  let eye = el.querySelector('i')
          toggleCSSclasses(eye, "fa-eye-slash", "fa-eye");
          if (pass.type === "password") {
            pass.type = "text";
          } else {
            pass.type = "password";
          }
		}
        const toggleCSSclasses = (el, ...cls) => cls.map(cl => el.classList.toggle(cl))
	</script>
</body>
</html>

