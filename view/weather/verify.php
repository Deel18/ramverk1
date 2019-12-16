<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h1>Weather</h1>

<p>Enter an IP/Geolocation to check the weather.</p>

<form method="post">
    <input type="text" name="ip">
    <br>
    <br>
    Latitude
    <br>
    <input type="text" name="latitude">
    </label>
    <br>
    <br>
    <label>
    Longitude
    <br>
    <input type="text" name="longitude">
    </label>
    <br>
    <br>
    <label>
    <input type="submit" name="verify" value="Verify">
</form>


<?php if ($res) : ?>
    <p><b><?= $res ?></b></p>
<?php endif; ?>

<?php if ($geo) : ?>
    <p><b><?= $geo ?></b></p>
<?php endif; ?>


<p><b><?= var_dump($weatherWeek) ?></b></p>


<?php if ($weatherWeek) : ?>

<h1> Weather report for upcoming 7 days.</h1>
<table>
    <tr>
        <th>Summary</th>
        <th>Time</th>
        <th>Temperature min</th>
        <th>Temperature Max</th>
        <th>Humidity</th>
    </tr>

    <tr>
    <?php foreach ($weatherWeek->data as $key => $row) : ?>
        <td><?= $row->summary ?></td>
        <td><?= gmdate("Y-m-d\ TH:i:s", $row->time) ?></td>
        <td><?= $row->temperatureMin ?></td>
        <td><?= $row->temperatureMax ?></td>
        <td><?= $row->humidity ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>
