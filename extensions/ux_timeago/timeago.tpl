{block 'post_time'}{$post.time_created|timeAgo}{/block}

{block 'last_reply'}{$post.last_reply|timeAgo}{/block}

{block 'category_last_reply'}{$value|timeAgo}{/block}

{block 'message_time'}{$message.time_created|timeAgo} ago{/block}