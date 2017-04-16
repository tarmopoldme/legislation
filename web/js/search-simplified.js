/* global instantsearch */

app({
    appId: 'QVD1349LIW',
    apiKey: 'b5e923d3449e176b28be4ad44c6777fd',
    indexName: 'legislation'
});

function app(opts) {
    const search = instantsearch({
        appId: opts.appId,
        apiKey: opts.apiKey,
        indexName: opts.indexName,
        urlSync: true,
        searchFunction: function(helper) {
            var searchResults = $('.hit');
            var pagination = $('#pagination')
            if (helper.state.query === '') {
                searchResults.hide();
                pagination.hide();
                return;
            }
            helper.search();
            searchResults.show();
            pagination.show();
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

    search.addWidget(
        instantsearch.widgets.pagination({
            container: '#pagination',
            scrollTo: '#search-input'
        })
    );
    search.start();
}

function getTemplate(templateName) {
    return document.querySelector(`#${templateName}-template`).innerHTML;
}

function getHeader(title) {
    return `<h5>${title}</h5>`;
}