<?php
/**
 * @var string $title
 * @var int $param
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
<?= $param ?>
<?php View::getFooter(); ?>
</body>
</html>
