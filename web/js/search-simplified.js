/* global instantsearch */

app({
    appId: 'latency',
    apiKey: '6be0576ff61c053d5f9a3225e2a90f76',
    indexName: 'instant_search'
});

function app(opts) {
    const search = instantsearch({
        appId: opts.appId,
        apiKey: opts.apiKey,
        indexName: opts.indexName,
        urlSync: true,
        searchFunction: function(helper) {
            var searchResults = $('.hit');
            if (helper.state.query === '') {
                searchResults.hide();
                return;
            }
            helper.search();
            searchResults.show();
        }
    });

    search.addWidget(
        instantsearch.widgets.searchBox({
            container: '#search-input',
            placeholder: 'Search for legislation act by title or content'
        })
    );

    search.addWidget(
        instantsearch.widgets.hits({
            container: '#hits',
            hitsPerPage: 10,
            templates: {
                item: getTemplate('hit'),
                empty: getTemplate('no-results')
            }
        })
    );

    // search.addWidget(
    //     instantsearch.widgets.pagination({
    //         container: '#pagination',
    //         scrollTo: '#search-input'
    //     })
    // );
    search.start();
}

function getTemplate(templateName) {
    return document.querySelector(`#${templateName}-template`).innerHTML;
}

function getHeader(title) {
    return `<h5>${title}</h5>`;
}