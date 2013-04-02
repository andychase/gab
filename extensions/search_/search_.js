
function prefix_q (q) {return {
    query: {
        text_phrase_prefix : {
            title: {
                query: q,
                max_expansions: 10
            }
        }
    },
    "highlight" : {
        "fields" : {
            "title" : {}
        }
    },
    from: 0,
    size: 10
};}

function queryElasticSearch(input, query, success) {
    var ajaxOptions;
    ajaxOptions = {
        dataType: "jsonp",
        type: "GET",
        url: search_url+"/forum/"+search_forum_id+"/_search",
        data: {
            source: JSON.stringify(query(input))
        },
        success: success
    };
    $.ajax(ajaxOptions);
}

var search_replace_section;

$(document).ready(function () {
    if ($("#forum_content").length)
        search_replace_section = $("#forum_content");


    function updateSearch(event) {
        // If field is now empty
        if (!$.trim(this.value).length) {
            // Clear input
            search_replace_section.show();
            $(".prev_next_paging").show();
            $("#search_results").hide();
        } else {
            // Update search results
            queryElasticSearch($(this).val(), prefix_q, function (data) {
                search_replace_section.hide();
                $(".prev_next_paging").hide();
                var sr = $("#search_results");
                if(sr.length) {
                    sr.show();
                    sr.html("");
                } else {
                    $("#forum").append("<ul id='search_results'></ul>");
                    sr = $("#search_results");
                }
                var curr;
                var curr_title;
                var curr_message;
                var curr_link;
                if (data.hits && data.hits.hits.length)
                    for (var i = 0; i < data.hits.hits.length; i++) {
                        curr = data.hits.hits[i];
                        if (curr.highlight)
                            curr_title = curr.highlight.title.join('');
                        else
                            curr_title = curr._source.title;
                        if (curr._source.type == 'post')
                            curr_link = '/'+curr._source.id;
                        else
                            curr_link = '/'+curr._source.reply_to+'#post'+curr._source.id;
                        curr_message = curr._source.message;
                        sr.append("<li><a href='"+curr_link+"'><b>"+curr_title+"</b> "+curr_message+"</a></li>");
                    }
                else
                    sr.append("<li>Nothing</li>");
            });
        }
    }
    $("#search input").bind('input',updateSearch);
});