
$(document).ready(function () {
    $('.reply').click(function () {
        var prev = $('#submit_reply textarea').val();
        var id =
            $(this).siblings('a.permalink').attr('href').split('#')[1].split('post')[1];
        var person =
            $(this).parent().parent().siblings('.post_user').children('.author_name').html();
        $('#submit_reply textarea').val('@'+person+':'+id+' '+prev);
    });


    var reply_to_matcher = /\@([a-z]+):([0-9]+)/i;
    var reply_to_replace = "<a href='#post$2' class='reply_to'> Reply to $1 </a>";
    if ($('#submit_reply').length > 0) {
        $(".savable textarea").on('input propertychange', function () {
            $(".savable #preview").html(
                $(this).val().replace(reply_to_matcher, reply_to_replace)
            );
        });
    }
});