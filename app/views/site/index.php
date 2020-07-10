<?php
/**
 * @var string $title
 * @var string $gg
*/

use Smp\Helpers\Url;
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
<a href="<?= Url::toRoute('lool', ['f' => 12314]) ?>">Libkk</a>
<?php View::getFooter(); ?>
</body>
</html>
