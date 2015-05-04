<h2 class="float-left"><?php echo $data['title']; ?></h2>
<div class="text-right">
    <fieldset>
        <form id="filter-results" method="get" action="<?php echo DIR; ?>games">
            <strong>Filter Results By:</strong>
            <div>
                <select id="console" name="console">
                    <option>Consoles</option>
                    <option name="1" <?php if($data['selectedConsole'] === 'Atari 2600') {
                        echo "selected='selected'"; } ?>>Atari 2600</option>
                    <option name="4" <?php if($data['selectedConsole'] === 'Atari 5200') {
                        echo "selected='selected'"; } ?>>Atari 5200</option>
                    <option name="7" <?php if($data['selectedConsole'] === 'Atari 7800') {
                        echo "selected='selected'"; } ?>>Atari 7800</option>
                    <option name="14" <?php if($data['selectedConsole'] === 'Atari Jaguar') {
                        echo "selected='selected'"; } ?>>Atari Jaguar</option>
                    <option name="5" <?php if($data['selectedConsole'] === 'ColecoVision') {
                        echo "selected='selected'"; } ?>>ColecoVision</option>
                    <option name="6" <?php if($data['selectedConsole'] === 'Commodore 64') {
                        echo "selected='selected'"; } ?>>Commodore 64</option>
                    <option name="2" <?php if($data['selectedConsole'] === 'Intellivision') {
                        echo "selected='selected'"; } ?>>Intellivision</option>
                    <option name="9" <?php if($data['selectedConsole'] === 'NES') {
                        echo "selected='selected'"; } ?>>NES</option>
                    <option name="13" <?php if($data['selectedConsole'] === 'SNES') {
                        echo "selected='selected'"; } ?>>SNES</option>
                    <option name="17" <?php if($data['selectedConsole'] === 'N64') {
                        echo "selected='selected'"; } ?>>N64</option>
                    <option name="8" <?php if($data['selectedConsole'] === 'Sega Master System') {
                        echo "selected='selected'"; } ?>>Sega Master System</option>
                    <option name="11" <?php if($data['selectedConsole'] === 'Sega 32X') {
                        echo "selected='selected'"; } ?>>Sega 32X</option>
                    <!--                    <option name="10">Sega CD</option>-->
                    <option name="12" <?php if($data['selectedConsole'] === 'Sega Genesis') {
                        echo "selected='selected'"; } ?>>Sega Genesis</option>
                    <option name="16" <?php if($data['selectedConsole'] === 'Sega Saturn') {
                        echo "selected='selected'"; } ?>>Sega Saturn</option>
                    <option name="15" <?php if($data['selectedConsole'] === 'PlayStation') {
                        echo "selected='selected'"; } ?>>PlayStation</option>
                </select>
            </div>
            <div>
                <select name="resultNum" id="resultNum">
                    <option>Per Page</option>
                    <option name="10" <?php if($data['selectedNumber'] === '10') {
                        echo "selected='selected'"; } ?>>10</option>
                    <option name="20" <?php if($data['selectedNumber'] === '20') {
                        echo "selected='selected'"; } ?>>20</option>
                    <option name="50" <?php if($data['selectedNumber'] === '50') {
                        echo "selected='selected'"; } ?>>50</option>
                    <option name="100" <?php if($data['selectedNumber'] === '100') {
                        echo "selected='selected'"; } ?>>100</option>
                </select>
            </div>
        </form>
    </fieldset>
</div>

<?php
    if(empty($data['games'])) {
        echo "<p>Sorry, there are currently no games stored in the database.</p>";
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

<div id="achievement">
    <div class="achievement-overlay"></div>
    <div id="achievement-content"></div>
</div>