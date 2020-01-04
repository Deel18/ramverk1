<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h1>Weather JSON</h1>

<p>Enter an IP/Geolocation to check the weather.</p>

<p>You can enter an IP/Geotag below or send a GET request to [baseurl]/weatjson/weatherjson?ip=x.x.x.xlatitude=x.xxxxx&longitude=xx.xxxxx&verify=Verify </p>


<form action="weatjson/weatherjson">
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
<br>
<br>
