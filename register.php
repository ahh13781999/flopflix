<?php 
require "./database/conn.php";
require "./config/config.php";
require "./class/Sanitizer.php";
require "./class/Account.php";
require "./class/Constants.php";
require "./middleware/auth.php";


if(isset($_SESSION['userEmail'])){
    header("Location: index.php");
}

$_SESSION['error'] = array();

$account = new Account($conn);

if(isset($_POST['submit'])){

     $firstName = Sanitizer::stringSanitizer($_POST['first_name']);
     $lastName = Sanitizer::stringSanitizer($_POST['last_name']);
     $email = Sanitizer::emailSanitizer($_POST['email']);
     $password = Sanitizer::passwordSanitizer($_POST['password']);
     $passwordConfirmation = Sanitizer::passwordSanitizer($_POST['password_confirmation']);

     $success = $account->register($firstName, $lastName, $email, $password, $passwordConfirmation);

     if($success){
     	$_SESSION['userEmail'] = $email;
     	header("Location: index.php");
     }
}

function getInputValue($value)
{
   if(isset($_POST[$value])){
   	echo $_POST[$value];
   }
}


 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="https://cdn.tailwindcss.com"></script>
	<title>
		Register
	</title>
</head>
<body class="antialiased overflow-x-hidden overflow-y-auto">
<main class="h-screen bg-blue-100">
	<section class="flex flex-row items-center justify-center mx-auto my-auto h-full">
		<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="bg-white rounded-lg flex flex-col items-center p-4 gap-y-6 w-full md:w-1/2 xl:w-1/3">
			<fieldset class="flex flex-col gap-y-2 w-full">
				<input type="text" name="first_name" class="border-0 border-b-2 focus:outline-0 focus:border-blue-300 p-2 border-blue-100 text-gray-600" placeholder="First Name" value="<?php getInputValue("first_name") ?>">	
				<?= $account->getError(Constants::$firstNameRequired) ?>
			    <?= $account->getError(Constants::$firstNameCharacters) ?>
			</fieldset>

			<fieldset class="flex flex-col gap-y-2 w-full">
				<input type="text" name="last_name" class="border-0 border-b-2 focus:outline-0 focus:border-blue-300 p-2 border-blue-100 text-gray-600" placeholder="Last Name" value="<?php getInputValue("last_name") ?>">
			<?= $account->getError(Constants::$lastNameRequired) ?>
			<?= $account->getError(Constants::$lastNameCharacters) ?>
			</fieldset>
	
			<fieldset class="flex flex-col gap-y-2 w-full">
				<input type="email" name="email" class="border-0 border-b-2 focus:outline-0 focus:border-blue-300 p-2 border-blue-100 text-gray-600" placeholder="Email" value="<?php getInputValue("email") ?>">			
			<?= $account->getError(Constants::$emailRequired) ?>
			<?= $account->getError(Constants::$emailValid) ?>
			<?= $account->getError(Constants::$emailExists) ?>
			</fieldset>
			<fieldset class="flex flex-col gap-y-2 w-full">
				<input type="password" name="password" class="border-0 border-b-2 focus:outline-0 focus:border-blue-300 p-2 border-blue-100 text-gray-600" placeholder="Password">		
			<?= $account->getError(Constants::$passwordRequired) ?>
			<?= $account->getError(Constants::$passwordMax) ?>
			<?= $account->getError(Constants::$passwordMin) ?>
			</fieldset>

			<fieldset class="flex flex-col gap-y-2 w-full">
				<input type="password" name="password_confirmation" class="border-0 border-b-2 focus:outline-0 focus:border-blue-300 p-2 border-blue-100 text-gray-600" placeholder="Password Confirmation">			
			<?= $account->getError(Constants::$passwordConfirm) ?>
			<?= $account->getError(Constants::$passwordMatch) ?>
			</fieldset>

			<input type="submit" name="submit" value="Submit!" class="py-2 px-4 bg-blue-500 text-white self-start rounded hover:opacity-70 text-lg">
			<p>Already have an account? <a class="underline font-semibold" href="">Sign in here!</a></p>
		</form>
	</section>
</main> 
</body>
</html>