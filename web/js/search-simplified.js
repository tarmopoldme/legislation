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
            },
            transformData: {
                item: function (data) {
                    ['highlight', 'snippet'].forEach(function (type) {
                        var group = data['_' + type + 'Result'];
                        for (var attr in group) {
                            if (!group.hasOwnProperty(attr)) continue;
                            var elt = group[attr];
                            elt.display = elt.matchLevel !== 'none';
                        }
                    });
                    data.displaySpecial = false || data._snippetResult.text.display;
                    return data;
                }
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