<h2><?php echo $data['title']; ?></h2>
<p><?php echo $data['message']; ?></p>

<?php
    foreach($data['games'] as $game) {
        echo "Successfully added game.<br>";
    }
?>