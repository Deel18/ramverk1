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
    <input type="text" name="ip" value="<?=$address?>">
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
    Latitude
    <br>
    <input type="text" name="latitude">
    </label>
    <br>
    <br>
    <input type="submit" name="verify" value="Verify">
</form>


<?php if ($res) : ?>
    <p><b><?= $res ?></b></p>
<?php endif; ?>

<?php if ($country_name) : ?>
    <p><b>Type:</b> <?= $type?></p>
    <p><b>Country:</b> <?= $country_name ?></p>
    <p><b>City:</b> <?= $city ?></p>
    <p><b>Longitude:</b> <?= $longitude ?></p>
    <p><b>Latitude:</b> <?= $latitude ?></p>
<?php endif; ?>
