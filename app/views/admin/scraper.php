
<table>
    <thead>
        <tr>
            <td>id</td>
            <td>title</td>
            <td>developer</td>
            <td>publisher</td>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($data['games'] as $game) {
                echo "<tr>
                            <td>$game->id</td>
                            <td>$game->title</td>
                            <td>$game->developer</td>
                            <td>$game->publisher</td>
                        </tr>";
            };
        ?>
    </tbody>
</table>