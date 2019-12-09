<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h1> Geotag JSON </h1>

<p>You can enter an IP below or send a GET request to [baseurl]/geojson/geotagjson?ip=x.x.x.x </p>


<form action="geojson/geotagjson">

    <p>
        <label>IP:<br>
        <input type="text" name="ip" value="<?= $address ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" value="Verify">
    </p>
</form>

<p>Example:
    <a href="geojson/geotagjson?ip=194.47.129.126">Sverige</a>
    <a href="geojson/geotagjson?ip=194.99.106.169">Frankrike</a>
</p>
