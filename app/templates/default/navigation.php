<nav class="layout-nav row pull-right">
    <div class="small-12 columns">
        <ul>
            <li><a href="<?php echo DIR ?>"><span>Home</span><i class="fa fa-home"></i></a></li>
        <?php $user = \helpers\session::get('user');
            if(empty($user)) { // if no user is logged in, display register/login links ?>
                <li><a href="<?php echo DIR ?>register"><span>Register</span><i class="fa fa-pencil"></i></a></li>
                <li><a href="<?php echo DIR ?>login"><span>Login</span><i class="fa fa-sign-in"></i></a></li>
        <?php } else { $role = $user->role; ?>
            <li><a href="<?php echo DIR ?>manage"><span>My Account</span><i class="fa fa-user"></i></a></li>
            <li><a href="<?php echo DIR ?>consoles"><span>Consoles</span><i class="fa fa-gamepad"></i></a></li>
            <li><a href="<?php echo DIR ?>games"><span>Games</span><i class="fa fa-gamepad"></i></a></li>
            <li><a href="<?php echo DIR ?>manage/collection"><span>Collection</span><i class="fa fa-book"></i></a></li>
            <li><a href="<?php echo DIR ?>manage/wishlist"><span>Wishlist</span><i class="fa fa-gift"></i></a></li>

            <?php if($role === 2) { ?>
                    <li><a href="<?php echo DIR ?>admin"><span>Admin</span><i class="fa-user-md"></i></a></li>
            <?php } ?>
            <li><a href="<?php echo DIR ?>logout"><span>Logout</span><i class="fa fa-sign-out"></i></a></li>
        <?php } ?>
        </ul>
    </div>
</nav>
</nav>