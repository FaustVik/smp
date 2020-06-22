<?php
/**
 * @var string $title
 * @var string $gg
*/

use Smp\View;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php View::getHead(); ?>
    <title><?= $title ?></title>
</head>
<body>
<?= $gg ?>
<?php View::getFooter(); ?>
</body>
</html>
