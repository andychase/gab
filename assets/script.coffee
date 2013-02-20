
###
   aScript
###


### Blog Page
###

$(document).ready ->
	### Blog Side Bar Hover ###
	bloghover = {
		".co"  :"home",
		"write":"write",
		"newer":"next",
		"older":"previous",
		"options":"cog",
		"share":"send",
		"feed" :"rss" }
	$("#sidebar ul li").each (i) ->
			el = $(this).children('a')
			id = $(this).children('a').attr('id')
			el.hover( ->
					el.addClass("ss-icon");
					el.html(bloghover[$(this).attr('id')])
			, ->
					el.removeClass("ss-icon");
					el.html($(this).attr('id'))
			)

	### Lights Off ###
	$("#lights_off").click ->
		option = $('body').toggleClass("light dark").attr('class')
		$.cookie('light_dark', option, { path: '/' })

	### Login on Home ###
	$("#signup").attr('href', 'javascript:void(0)')
	$("#signup").click ->
		$("#blog_here_blurb").slideUp(200)
		$("#homepage_login_signup").show()
	if $("#homepage_login_signup").length > 0
		$("#login").attr('href', 'javascript:void(0)')
		$("#login").click ->
			$("#blog_here_blurb").slideUp(200)
			$("#homepage_login_signup").show()
	### ChromaHash ###
	if $("#login_or_signup").length > 0
		$("#login_or_signup input:password").chromaHash({bars: 3, salt:"8be82b35cb0100120eea35a4507c9acf", minimum:4});


	### Forum show in middle ###
	if (window.location.hash != "")
		setTimeout( ->
			$(window).scrollTop(Math.ceil(($(window.location.hash).offset().top - ($(window).height()) / 2)))
			$(window.location.hash).parent().parent().children(".post_body").addClass("highlight")
			0
		, 100
		);
		0

	### Markdown Preview & Draft Saving ###
	if $(".savable").length
		if ($.cookie("reply_url") == location.pathname)
			$(".savable textarea").val($.cookie("reply_text"))
		$(".savable textarea").bind('input propertychange', ->
			$("#save_hover").hide(); $("#save_hover_clear").hide()
			$("#save_warning").hide();
			$.cookie("reply_url", location.pathname, {expires: 1, path: '/'})
			$.cookie("reply_text", $(this).val(), {expires: 1, path: '/'})
			$(".savable #preview").html(marked($(this).val()))
		)

	if ($.cookie("reply_text") && $.cookie("reply_text").trim() != "" &&
		$.cookie("reply_url") != "" &&
		$.cookie("reply_url") != location.pathname)
			$("#save_warning").html("If you type here, your previous draft will be trashed.")
			$("body").append("""
				<a id='save_hover' href='#{$.cookie("reply_url")}#reply'>
					You have a saved draft waiting to be finished.

				</a>
				<button type='button' id='save_hover_clear' class='.ss-delete'>discard</button>
				""")

	$("#save_hover_clear").click ->
		$.removeCookie("reply_url", {path: '/'})
		$.removeCookie("reply_text", {path: '/'})
		$("#save_hover").animate({"bottom": "-60px"}, 400, 'swing', -> $(this).hide())
		$("#save_hover_clear").animate({"bottom": "-60px"}, 400, 'swing', -> $(this).hide())
		$("#save_warning").hide(400)


	### Show new Thread composer ###
	$("#new_link").attr("href", "javascript:void(0);")
	$("#new_link").click ->
		$("#new_thread").toggle(200, 'swing')
	### Autoopen if hash in url ###
	if (window.location.hash == "#new_thread" || window.location.hash == "#reply")
		$("#new_thread").toggle()



	### Category Colorizer ###
	colorizer = ->
		input = $(this)
		md5 = hex_md5(input.html().trim())
		colors = md5.match(/([\dABCDEF]{6})/ig);
		color = parseInt(colors[0], 16)
		red = (color >> 16) & 255
		green = (color >> 8) & 255
		blue = color & 255
		hex = $.map([red, green, blue], (c, i) ->
			((c >> 4) * 0x10).toString 16
		).join("")
		$(this).css backgroundColor: "#" + hex

	$(".category").each(colorizer)


	### New Category Previewer ###
	if $("#new_category_description").length > 0
		$("#preview").html("""<table class="category_table"><thead><tr>
			<th colspan="3"><a href="/" class="category">
			</a><span class="description"></span>
			</th></tr></thead></table>
			""")
		title_box = $("#new_thread_title")
		desc_box = $("#new_category_description")
		preview_title = $("#preview .category")
		preview_description = $("#preview .description")
		title_box.keyup ->
			preview_title.html(title_box.val())
			preview_title.each(colorizer)
		desc_box.keyup ->
			preview_description.html(desc_box.val())
