<h1>Hello Trevor, here are your list of contacts.</h1><br />

<?php foreach($contacts as $contact) : ?>

<label><?php print $contact["Name"]; ?></label><br />

<?php endforeach; ?>

<br /><br /><label><h1><?php print $message; ?></h1></label>