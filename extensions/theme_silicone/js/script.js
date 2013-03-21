$(document).ready(function () {

    /* Forum show in middle */
    var colorizer, desc_box, preview_description, preview_title, title_box;
    function highlight_hash() {
        $(window).scrollTop(Math.ceil($(window.location.hash).offset().top - ($(window).height()) / 2));
        $('.highlight').removeClass('highlight');
        $(window.location.hash).parent().parent().children(".post_body").addClass("highlight");
    }

    $(window).on('hashchange', highlight_hash);
    if (window.location.hash !== "")
        setTimeout(highlight_hash, 100);

    /* Draft Saving */
    if ($(".savable").length) {
        if ($.cookie("reply_url") === location.pathname) {
            $(".savable textarea").val($.cookie("reply_text"));
        }
        $(".savable textarea").bind('input propertychange', function () {
            $("#save_hover").hide();
            $("#save_hover_clear").hide();
            $("#save_warning").hide();
            $.cookie("reply_url", location.pathname, {
                expires: 1,
                path: '/'
            });
            $.cookie("reply_text", $(this).val(), {
                expires: 1,
                path: '/'
            });
        });
    }
    if ($.cookie("reply_text") && $.cookie("reply_text").trim() !== "" && $.cookie("reply_url") !== "" && $.cookie("reply_url") !== location.pathname) {
        $("#save_warning").html("If you type here, your previous draft will be trashed.");
        $("body").append("<a id='save_hover' href='" + ($.cookie("reply_url")) + "#reply'>\n	You have a saved draft waiting to be finished.\n\n</a>\n<button type='button' id='save_hover_clear' class='.ss-delete'>discard</button>");
    }
    $("#save_hover_clear").click(function () {
        $.removeCookie("reply_url", {
            path: '/'
        });
        $.removeCookie("reply_text", {
            path: '/'
        });
        $("#save_hover").animate({
            "bottom": "-60px"
        }, 400, 'swing', function () {
            $(this).hide();
        });
        $("#save_hover_clear").animate({
            "bottom": "-60px"
        }, 400, 'swing', function () {
            return $(this).hide();
        });
        $("#save_warning").hide(400, function () {
            $(this).html("");
        });
    });

    /* Show new Thread composer */
    $("#new_link").attr("href", "javascript:void(0);");
    $("#new_link").click(function () {
        return $("#new_thread").slideToggle(200, 'swing');
    });

    /* Auto-open if hash in url */
    if (window.location.hash === "#new_thread" || window.location.hash === "#reply") {
        $("#new_thread").toggle();
    }

    /* Category Colorizer */
    colorizer = function () {
        var blue, color, colors, green, hex, input, md5, red;
        input = $(this);
        md5 = hex_md5(input.html().trim());
        colors = md5.match(/([\dABCDEF]{6})/ig);
        color = parseInt(colors[0], 16);
        red = (color >> 16) & 255;
        green = (color >> 8) & 255;
        blue = color & 255;
        hex = $.map([red, green, blue], function (c) {
            return ((c >> 4) * 0x10).toString(16);
        }).join("");
        return $(this).css({
            backgroundColor: "#" + hex
        });
    };
    $(".category").each(colorizer);

    /* New Category Previewer */
    if ($("#new_category_description").length) {
        $("#preview").html("<table class=\"category_table\"><thead><tr>\n<th colspan=\"3\"><a href=\"/\" class=\"category\">\n</a>\n</th></tr></thead></table>");
        title_box = $("#new_thread_title");
        desc_box = $("#new_category_description");
        preview_title = $("#preview .category");
        title_box.keyup(function () {
            preview_title.html(title_box.val());
            preview_title.each(colorizer);
        });
    }


    var warning = $("#new_thread .warning");
    $("#new_thread_title").bind('input', function (){
        if ($(this).val().length > 80)
            warning.html($(this).val().length - 80 + " characters in title will be cut off.  ");
        else if ($(this).val().length > 65)
            warning.html(80 - $(this).val().length + " characters left in title. Rest will be cut off.");
        else
            warning.html("");
    });
    $("#new_thread textarea").bind('input', function (){
        if ($(this).val().length > 5000)
            warning.html($(this).val().length - 5000 + " characters in message will be cut off.  ");
        else if ($(this).val().length > 4950)
            warning.html(5000 - $(this).val().length + " characters left in message. Rest will be cut off.");
        else
            warning.html("");
    });


    /* Reply Button */
    $('.reply').click(function () {
        var prev = $('#submit_reply textarea').val();
        var id =
            $(this).siblings('a.permalink').attr('href').split('#')[1].split('post')[1];
        var person =
            $(this).parent().parent().siblings('.post_user').children('.author_name').html();
        $('#submit_reply textarea').val('@'+person+':'+id+' '+prev);
    });

    $('.at_reply_link').attr('href', 'javascript:void(0);')
    $('.at_reply_link').click(function () {
        $(this).siblings('.at_reply_message').slideToggle('fast');
    });

    /* Watch Hider */
    $('#watch_email').hide();
    $('.watch').click(function () {
        $('#watch_email').show('fast');
    });


});