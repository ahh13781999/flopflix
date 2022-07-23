<?php

require "./includes/header.php";

if(!isset($_SESSION['userEmail'])){
    header("Location: login.php");
}

 
$account = new Account($conn);
$detailsMessage = "";
$passwordMessage = "";

if(isset($_POST['saveDetailsButton'])){
	$_SESSION['error'] = [];
     $firstName = Sanitizer::stringSanitizer($_POST['firstName']);
     $lastName = Sanitizer::stringSanitizer($_POST['lastName']);
     $email = Sanitizer::emailSanitizer($_POST['email']);

     if($account->updateDetails($firstName,$lastName,$email,$_SESSION['userEmail'])){
          $detailsMessage = "<p class='text-green-400 text-lg font-semibold'>Profile updated successfully!</p>";
     }else{
          $detailsMessage = "<p class='text-red-400 text-lg font-semibold'>Something went wrong!</p>";
     }
}

if(isset($_POST['savePasswordButton'])){
	$_SESSION['error'] = [];
     $oldPassword = Sanitizer::passwordSanitizer($_POST['oldPassword']);
     $newPassword = Sanitizer::passwordSanitizer($_POST['newPassword']);
     $passwordConfirmation = Sanitizer::passwordSanitizer($_POST['passwordConfirmation']);

     if($account->updatePassword($oldPassword,$newPassword,$passwordConfirmation,$_SESSION['userEmail'])){
          $passwordMessage = "<p class='text-green-400 text-lg font-semibold'>Password updated successfully!</p>";
     }else{
          $passwordMessage = "<p class='text-red-400 text-lg font-semibold'>Something went wrong!</p>";
     }
}

?>

<div class="flex flex-col items-center pt-20 w-full h-full px-8">
	<div class="my-28 w-full flex flex-col gap-y-3">
		<h2 class="text-white text-2xl font-semibold">User details</h2>
		<?php $user = new User($conn,$_SESSION['userEmail']) ?>
		<?php if(isset($detailsMessage)) echo $detailsMessage; ?>
		<form method="POST" class="flex flex-col items-start gap-y-3 w-full">
          <input class="w-full md:w-2/3 lg:w-1/2 xl:w-1/3 py-2 rounded pl-2" type="text" name="firstName" value="<?= $user->getFirstName() ?>" placeholder="First Name">
			    <?= $account->getError(Constants::$firstNameRequired) ?>
			    <?= $account->getError(Constants::$firstNameCharacters) ?>
          <input class="w-full md:w-2/3 lg:w-1/2 xl:w-1/3 py-2 rounded pl-2" type="text" name="lastName" value="<?= $user->getLastName() ?>" placeholder="Last Name">
			   	<?= $account->getError(Constants::$lastNameRequired) ?>
			    <?= $account->getError(Constants::$lastNameCharacters) ?>
          <input class="w-full md:w-2/3 lg:w-1/2 xl:w-1/3 py-2 rounded pl-2" type="email" name="email" value="<?= $user->getEmail() ?>" placeholder="Email">
		     	<?= $account->getError(Constants::$emailRequired) ?>
			    <?= $account->getError(Constants::$emailValid) ?>
			    <?= $account->getError(Constants::$emailExists) ?>
          <input type="submit" value="Save" name="saveDetailsButton" class="bg-red-500 text-lg text-white px-3 py-1 rounded hover:opacity-70">
		</form>
	</div>
	<div class="w-full flex flex-col gap-y-3">
		<h2 class="text-white text-2xl font-semibold">Update password</h2>
		<?php if(isset($passwordMessage)) echo $passwordMessage; ?>
		<form method="POST" class="flex flex-col items-start gap-y-3">
          <input class="w-full md:w-2/3 lg:w-1/2 xl:w-1/3 py-2 rounded pl-2" type="password" name="oldPassword" placeholder="Old Password"> 
          <?= $account->getError(Constants::$passwordRequired) ?>
					<?= $account->getError(Constants::$passwordMax) ?>
					<?= $account->getError(Constants::$passwordMin) ?> 
          <input class="w-full md:w-2/3 lg:w-1/2 xl:w-1/3 py-2 rounded pl-2" type="password" name="newPassword" placeholder="New Password">
          <?= $account->getError(Constants::$passwordRequired) ?>
					<?= $account->getError(Constants::$passwordMax) ?>
					<?= $account->getError(Constants::$passwordMin) ?> 
          <input class="w-full md:w-2/3 lg:w-1/2 xl:w-1/3 py-2 rounded pl-2" type="password" name="passwordConfirmation" placeholder="Confirm New Password"> 
          <?= $account->getError(Constants::$passwordConfirm) ?>
	     <?= $account->getError(Constants::$passwordMatch) ?>
			    <input type="submit" value="Update" name="savePasswordButton" class="bg-red-500 text-lg text-white px-3 py-1 rounded hover:opacity-70">
		</form>
	</div>
</div>
  </main>
 <script type="text/javascript" src="./src/script.js"></script>
</body>
</html>