<?php if($data['title']) { echo "<h2>" . $data['title'] . "</h2>"; } ?>
<?php if($data['message']) { echo "<p>" . $data['message'] . "</p>"; } ?>

<?php
    if(empty($data['consoles'])) {
        echo "<p>" . $data['no-consoles'] . "</p>";
    } else {
        echo "<ul class='consoles'>";

        foreach ($data['consoles'] as $console) {
            ?>

            <li>
                <img src="<?php echo \helpers\url::get_template_path(); ?>images/consoles/consoles/<?php
                echo $console->id; ?>.jpg" alt="<?php echo $console->name; ?>">
                <h2><?php echo $console->name . "<br>($console->year)"; ?></h2>
                <div class="console-collection">
                    <strong>Collection: </strong>
                    <?php if ($console->inCollection === true) { ?>
                        <span class="removeconsolefromcollection">
                            <a class="<?php echo $console->id; ?>"><i class="fa fa-check"></i></a>
                        </span>
                    <?php } else { ?>
                        <span class="addconsoletocollection">
                            <a class="<?php echo $console->id; ?>"><i class="fa fa-book"></i></a>
                        </span>
                    <?php } ?>
                </div>
                <div class="console-wishlist">
                    <strong>Wishlist: </strong>
                    <?php if ($console->inWishlist === true) { ?>
                        <span class="removeconsolefromwishlist">
                            <a class="<?php echo $console->id; ?>"><i class="fa fa-check"></i></a>
                        </span>
                    <?php } else { ?>
                        <span class="addconsoletowishlist">
                            <a class="<?php echo $console->id; ?>"><i class="fa fa-gift"></i></a>
                        </span>
                    <?php } ?>
                </div>
            </li>
        <?php
        }
        echo "</ul>";
    }
?>