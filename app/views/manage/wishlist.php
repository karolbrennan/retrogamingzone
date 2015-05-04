<?php if($data['title']) { echo "<h2>" . $data['title'] . "</h2>"; } ?>
<?php if($data['message']) { echo "<p>" . $data['message'] . "</p>"; } ?>
<h3>Games</h3>
<?php
if(empty($data['games'])) {
    echo "<p>" . $data['no-games'] . "</p>";
} else {
    echo $data['pages'];
    echo "<ul class='games'>";
    foreach ($data['games'] as $game) { ?>

        <li>
            <img src="<?php echo \helpers\url::get_template_path(); ?>images/consoles/<?php
            echo $game->console; ?>/<?php echo $game->id; ?>.jpg" alt="<?php echo $game->title; ?>">
            <h2><?php echo $game->title . "<br>";
                if(!is_null($game->release_date)) { echo "(" . $game->release_date . ")"; } ?></h2>
            <?php
            if(!is_null($game->consoleName)) {
                echo "<span><strong>Console: </strong>" . $game->consoleName . "</span>";
            }
            if(!is_null($game->releaseDate)) {
                echo "<span><strong>Release Date: </strong>" . $game->releaseDate . "</span>";
            }
            if(!is_null($game->rating)) {
                echo "<span><strong>Rating: </strong>" . $game->rating . "</span>";
            }
            if(!is_null($game->developer)) {
                echo "<span><strong>Developer: </strong>" . $game->developer . "</span>";
            }
            if(!is_null($game->publisher)) {
                echo "<span><strong>Publisher: </strong>" . $game->publisher . "</span>";
            }
            if(!is_null($game->genre)) {
                echo "<span><strong>Genre: </strong>" . $game->genre . "</span>";
            }
            ?>

            <div class="game-collection"><strong>Collection:</strong>
                <?php if($game->inCollection === true) { ?>
                    <span class="removegamefromcollection">
                            <a class="<?php echo $game->id; ?>"><i class="fa fa-check"></i></a>
                        </span>
                <?php } else { ?>
                    <span class="addgametocollection">
                            <a class="<?php echo $game->id; ?>"><i class="fa fa-book"></i></a>
                        </span>
                <?php } ?>
            </div>
            <div class="game-wishlist"><strong>Wishlist:</strong>
                <?php if($game->inWishlist === true) { ?>
                    <span class="removegamefromwishlist">
                            <a class="<?php echo $game->id; ?>"><i class="fa fa-check"></i></a>
                        </span>
                <?php } else { ?>
                    <span class="addgametowishlist">
                            <a class="<?php echo $game->id; ?>"><i class="fa fa-gift"></i></a>
                        </span>
                <?php } ?>
            </div>
        </li>
    <?php  }
    echo "</ul>";
    echo $data['pages'];
}
?>
<h3>Consoles</h3>

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


<div id="achievement">
    <div class="achievement-overlay"></div>
    <div id="achievement-content"></div>
</div>