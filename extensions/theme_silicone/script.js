$(document).ready(function () {

    /* Forum show in middle */
    var colorizer, desc_box, preview_description, preview_title, title_box;
    if (window.location.hash !== "") {
        setTimeout(function () {
            $(window).scrollTop(Math.ceil($(window.location.hash).offset().top - ($(window).height()) / 2));
            $(window.location.hash).parent().parent().children(".post_body").addClass("highlight");
            return 0;
        }, 100);
    }
    /* Markdown Preview & Draft Saving */

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
            return $(".savable #preview").html(marked($(this).val()));
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
            return $(this).hide();
        });
        $("#save_hover_clear").animate({
            "bottom": "-60px"
        }, 400, 'swing', function () {
            return $(this).hide();
        });
        return $("#save_warning").hide(400);
    });

    /* Show new Thread composer */
    $("#new_link").attr("href", "javascript:void(0);");
    $("#new_link").click(function () {
        return $("#new_thread").toggle(200, 'swing');
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
    if ($("#new_category_description").length > 0) {
        $("#preview").html("<table class=\"category_table\"><thead><tr>\n<th colspan=\"3\"><a href=\"/\" class=\"category\">\n</a><span class=\"description\"></span>\n</th></tr></thead></table>");
        title_box = $("#new_thread_title");
        desc_box = $("#new_category_description");
        preview_title = $("#preview .category");
        preview_description = $("#preview .description");
        title_box.keyup(function () {
            preview_title.html(title_box.val());
            return preview_title.each(colorizer);
        });
        return desc_box.keyup(function () {
            return preview_description.html(desc_box.val());
        });
    }


});