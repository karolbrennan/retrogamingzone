<h2><?php echo $data['title']; ?></h2>

<?php
    if(!empty($data['sticky-form'])) {
        $email = $data['sticky-form']['email'];
    }
    if(!empty($data['errors'])) {
        $comboError = $data['errors']['login']['combo'];
        $nameError = $data['errors']['login']['name'];
        $passwordError = $data['errors']['login']['password'];
    }
    if(!empty($comboError)) {
        echo "<p>$comboError</p>";
    }
?>

<fieldset>
    <form id="login" method="post" action="<?php echo DIR; ?>login/process">
        <input type="email" name="email" placeholder="@"
            <?php if(!empty($email)) { echo "value='" . $email . "'"; } ?> required>
        <?php if(!empty($emailError)) { echo "<p class='error'>$emailError</p>"; } ?>
        <input type="password" name="password" placeholder="Password" required>
        <?php if(!empty($passwordError)) { echo "<p class='error'>$passwordError</p>"; } ?>

        <input type="submit" name="login" value="Login">
    </form>
</fieldset>