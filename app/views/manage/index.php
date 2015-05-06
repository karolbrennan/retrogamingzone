<h2><?php echo $data['title']; ?></h2>
<p>Hello,
<?php echo $data['user']->name; ?>!</p>
<p>You currently have <?php echo \services\Collection::getCurrentUserGameCountCollection(); ?> games in your collection!</p>


<h2>Achievements</h2>
<?php if(!empty($data['achievements'])) { ?>
<ul class="achievements">
    <?php
    foreach($data['achievements'] as $achievement) {
        echo "<li>";
        echo "<img src='" . \helpers\url::get_template_path() . "images/badges/" .
            $achievement['achievement_badge'] . "'><br>";
        echo $achievement['achievement_text'] . "<br>";

        echo "</li>";
    }
    ?>
</ul>
<?php } else { ?>
   <p>You don't have any achievements yet, continue adding to your collection to earn some badges!</p>
<?php }?>