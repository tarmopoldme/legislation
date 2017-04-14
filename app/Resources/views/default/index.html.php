<?php $view->extend('::base.html.php') ?>
<!-- INTERFACE -->
<header>
    <div id="search-input"></div>
    <div id="search-input-icon"></div>
</header>

<main>
    <div id="right-column">
        <div id="sort-by-wrapper"><span id="sort-by"></span></div>
        <div id="stats"></div>
        <div id="hits"></div>
        <div id="pagination"></div>
    </div>
</main>

<!-- TEMPLATES -->
<script type="text/html" id="hit-template">
    <div class="hit">
        <div class="hit-image">
            <img src="{{image}}" alt="{{name}}">
        </div>
        <div class="hit-content">
            <h3 class="hit-price">${{price}}</h3>
            <h2 class="hit-name">{{{_highlightResult.name.value}}}</h2>
            <p class="hit-description">{{{_highlightResult.description.value}}}</p>
        </div>
    </div>
</script>

<script type="text/html" id="no-results-template">
    <div id="no-results-message">
        <p>We didn't find any results for the search <em>"{{query}}"</em>.</p>
        <a href="." class='clear-all'>Clear search</a>
    </div>
</script>
<!-- /TEMPLATES -->