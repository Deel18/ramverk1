<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h1>Geotag</h1>

<p>Enter an IP address to verify it.</p>

<form method="post">
    <input type="text" name="ip" value="<?=$address?>">
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
