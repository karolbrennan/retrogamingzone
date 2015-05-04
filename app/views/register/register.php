<h2><?php echo $data['title']; ?></h2>
<p><?php echo $data['message']; ?></p>

<?php
    if(!empty($data['sticky-form'])) {
        $name = $data['sticky-form']['name'];
        $email = $data['sticky-form']['email'];
        $password = $data['sticky-form']['password'];
        $confirmpw = $data['sticky-form']['confirmpw'];
    }
    if(!empty($data['errors'])) {
        $required = $data['errors']['registration']['required'];
        $userExists = $data['errors']['registration']['userexists'];
        $nameError = $data['errors']['registration']['name'];
        $emailError = $data['errors']['registration']['email'];
        $passwordError = $data['errors']['registration']['password'];
        $confirmpwError = $data['errors']['registration']['confirmpw'];
        $pwMatchError = $data['errors']['registration']['passwordmatch'];
    }
    if(!empty($required)) {
        echo "<p>$required</p>";
    }

    if(!empty($userExists)){
        echo "<p>$userExists</p>";
    }
?>

<fieldset>
    <form id="register" method="post" action="<?php echo DIR; ?>register/process">
        <input type="text" name="name" placeholder="Name"
            <?php if(!empty($name)) { echo "value='" . $name . "'"; } ?> required>
        <?php if(!empty($nameError)) { echo "<p class='error'>$nameError</p>"; } ?>

        <input type="email" name="email" placeholder="@"
            <?php if(!empty($email)) { echo "value='" . $email . "'"; } ?> required>
        <?php if(!empty($emailError)) { echo "<p class='error'>$emailError</p>"; } ?>

        <input type="password" name="password" placeholder="Password *"
            <?php if(!empty($password)) { echo "value='" . $password . "'"; } ?> required>
        <?php if(!empty($passwordError)) { echo "<p class='error'>$passwordError</p>"; } ?>

        <input type="password" name="confirmpw" placeholder="Confirm Password *"
            <?php if(!empty($confirmpw)) { echo "value='" . $confirmpw . "'"; } ?> required>
        <?php if(!empty($confirmpwError)) { echo "<p class='error'>$confirmpwError</p>"; } ?>

        <?php if(!empty($pwMatchError)) { echo "<p class='error'>$pwMatchError</p>"; } ?>
        <input type="submit" name="register" value="Register">

        <p class="help">* Passwords must contain 8-16 alpha-numeric characters.</p>
    </form>
</fieldset>