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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body>
<?= $gg ?>
<a href="<?= Url::toRoute('lool', ['f' => 12314]) ?>">Libkk</a>
<?php View::getFooter(); ?>
</body>
<script>
    $(function () {
        $.post('<?= Url::toRoute('site/test') ?>', {id:123}, function () {

        });
    });
</script>
</html>
