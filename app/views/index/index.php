<div class="row">
    <div class="small-12 medium-6 columns">
        <h2>Welcome<?php
            if ($data['user']) {
                echo ', ' . $data['user']->name . "!</h2>";
                echo "<p>You currently have " . $data['games'] . " ";
                        if($data['games'] === 1) {
                            echo "game";
                        } else {
                            echo "games";
                        };
                     echo " in your collection!</p>";
            } else {
                echo "!</h2>";
                echo "<p>Track your retro gaming consoles and cartridges here!</p>";
            }
            fb::info($data['user'], $data['games'], $data['consoles']);
            ?>
    </div>
    <div class="small-12 medium-6 columns">
        <h2>Leaderboard</h2>
        <ul id="leaderboard"></ul>
    </div>
</div>

<script type="text/javascript" src="<?php echo \helpers\url::get_template_path(); ?>js/leaderboard.js"></script>
<script type="text/javascript" src="<?php echo \helpers\url::get_template_path(); ?>js/jquery.tinysort.min.js"></script>