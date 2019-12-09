<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h1> IP verification</h1>

<p>Enter an IP address to verify it.</p>

<form method="post">
    <input type="text" name="ip">
    <input type="submit" name="verify" value="Verify">
</form>


<?php if ($res) : ?>
    <p><b><?= $res ?></b></p>
<?php endif; ?>
