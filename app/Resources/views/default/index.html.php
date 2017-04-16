<?php
$view->extend('::base.html.php');
/** @var Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper $assetsHelper */
$assetsHelper = $view['assets'];
?>
<header>
    <div id="search-input">
    </div>
    <div id="search-input-icon">
    </div>
</header>

<main>
    <small>Search by</small>
        <a href="https://www.algolia.com">
            <img id="algolia-logo" width="40" src="<?php echo $assetsHelper->getUrl('img/Algolia_logo_bg-white.jpg')?>" />
        </a>
    <div id="right-column">
        <div id="hits"></div>
        <div id="pagination"></div>
    </div>
</main>
<footer></footer>

<script type="text/html" id="hit-template">
    <div class="hit">
        <div class="hit-content">
            <h2 class="hit-name">{{{_highlightResult.name.value}}}</h2>
            <a target="_blank" href="{{url}}">{{url}}</a> <br />
            <small>Weight: {{weight}}</small>
        </div>
    </div>
</script>

<script type="text/html" id="no-results-template">
    <div id="no-results-message">
        <p>We didn't find any results for the search <em>"{{query}}"</em>.</p>
        <a href="." class='clear-all'>Clear search</a>
    </div>
</script>