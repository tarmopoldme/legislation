<?php
/** @var Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper $assetsHelper */
$assetsHelper = $view['assets'];
/** @var Symfony\Component\Templating\Helper\SlotsHelper $slotsHelper */
$slotsHelper = $view['slots'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Legislation search prototype</title>
        <!-- IE < 10 support -->
        <!--[if lte IE 9]>
        <script src="<?php echo $assetsHelper->getUrl('js/polyfill.min.js')?>"></script>
        <![endif]-->
        <link rel="stylesheet" href="<?php echo $assetsHelper->getUrl('css/instantsearch.min.css')?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $assetsHelper->getUrl('css/style.css')?>">
        <link rel="icon" type="image/x-icon" href="<?php echo $assetsHelper->getUrl('favicon.ico')?>" />
    </head>
    <body>
        <?php $slotsHelper->output('_content') ?>
        <script src="<?php echo $assetsHelper->getUrl('js/jquery-3.2.1.min.js')?>"></script>
        <script src="<?php echo $assetsHelper->getUrl('js/instantsearch.min.js')?>"></script>
        <script src="<?php echo $assetsHelper->getUrl('js/search-simplified.js')?>"></script>
    </body>
</html>
