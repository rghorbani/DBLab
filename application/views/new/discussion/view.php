<?php
	
	function showPageNumber($i, $c=0, $p=NULL, $set=false) {
		static $current = 1;
		static $topic_head = NULL;
		if ($set) { $current = $c; $topic_head=$p; return; }
		if ($i != $current) echo '<li><a href="' . site_url("discussion/topic/" . $topic_head->id . "/" . $i) . '">' . $i . '</a></li> ';
		else					 echo '<li class="selected">' . $i . '</li> ';
	}
	showPageNumber(0, $current_page, $topic_head, true);
	
	$quoted_text = "";
	if ($quoted_post != NULL) {
		$quoted_text = "> **" . $quoted_post->name . "** said:\n\n> " . str_replace(array("\r","\n"), array("","\n> "), markdownify($quoted_post->text)) . "\n\n";
	}
?>

		</div>

<script src="<?=site_url("assets/ace/ace.js")?>" type="text/javascript" charset="utf-8"></script>
<script src="<?=site_url("assets/showdown/showdown.js")?>" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?=site_url("assets/theme_new/discussion.js?1")?>"></script>
<script>
	prep_viewtopic();
	<? if ($quoted_text != "") echo("editor.focus();"); ?>
</script>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						problem_tabs($is_logged_in, $current_user, TAB_PROBLEM_DISCUSSION, $problem);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<? if (count($posts) > 0) { ?>
					<div id="paging">
						<span>pages:</span>
							<ul>
								<?php
								if ($total_pages < 12) {
									for ($i=1;$i<=$total_pages;$i++) showPageNumber($i);
								}else {
									if ($current_page < 6) {
										for ($i=1;$i<7;$i++) showPageNumber($i);
										echo " ... ";
										for ($i=$total_pages-3;$i!=$total_pages+1;$i++) showPageNumber($i);
									}else if ($current_page > $total_pages-6) {
										for ($i=1;$i<3;$i++) showPageNumber($i);
										echo " ... ";
										for ($i=$total_pages-6;$i!=$total_pages+1;$i++) showPageNumber($i);
									}else {
										for ($i=1;$i<4;$i++) showPageNumber($i);
										echo " ... ";
										 showPageNumber($current_page-1);
										 showPageNumber($current_page);
										 showPageNumber($current_page+1);
										echo " ... ";
										for ($i=$total_pages-3;$i!=$total_pages+1;$i++) showPageNumber($i);
									}
								}
								?>
							</ul>	
					</div>
					<?php } ?>
					<? if ($is_logged_in) { ?>
					<div class="page-controls">
						<? if ($subscribed) { ?><div id="unfollow-btn" class="button">Following</div>
						<? } else {?><div id="follow-btn" class="button">Not following</div><? } ?>
					</div>
					<? } ?>
					<div class="clear"></div>
					<div id="discussion_post_container">
					<?php
						foreach ($posts as $post) {
							$pic = site_url("assets/user_images/$post->picture");
							$pic = substr($pic, 0, strlen($pic)-4) . "_thumb.jpg";
					?>
					<div class="discussion_post_info" id="discussion_post_info_<?=$post->id?>">
							<a name="post_<?=$post->id?>"></a>
							<div class="content">
								<a href="<?=site_url("users/profile/" . $post->user_id)?>"><img src="<?=$pic?>" /></a>
							</div>
					</div>
					<div class="discussion_post shadowed" id="discussion_post_<?=$post->id?>">
						<div class="inner-box">
							<div class="content md">
								<div class="discussion_post_header">
									<a href="<?=site_url("users/profile/" . $post->user_id)?>"><strong><?=$post->name?></strong></a> <small>SAYS</small>
									<div class="controls">
										<? if ($is_logged_in) { ?><a class="discussion_quote_link" id="discussion_quote_link_<?=$post->id?>" href="<?=site_url("discussion/topic/" . $topic_head->id . "/" . $current_page . "/?quote=" . $post->id . "#message")?>">Quote</a><? } ?>
										<? if ($is_logged_in && ($current_user->perm_moderator || $current_user->id == $post->user_id)) {?>
										<? if ($post->id == $topic_head->id) { ?><a class="discussion_delete_link discussion_topic_delete_link" id="discussion_delete_link_<?=$post->id?>" href="<?=site_url("discussion/delete/" . $post->id)?>">Delete Topic</a>
										<? } else { ?><a class="discussion_delete_link" id="discussion_delete_link_<?=$post->id?>" href="<?=site_url("discussion/delete/" . $post->id . "?next=" . $CURRENT_PAGE)?>">Remove</a><?php } ?>
										<? } ?>
									</div>
								</div>
								<?=($post->text)?>
								<div class="clear"></div>
								<div class="discussion_post_footer"><small><?=date2ago($post->time)?></small></div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<?php } ?>
					</div>
					<?php if (count($posts) == 0) {
					?>
					<div class="discussion_nopost shadowed">
						<div class="inner-box">
							<div class="content">
								<strong>No posts yet!</strong><br /><br />
								<p>Ask your questions, discuss about this problem and share your ideas!</p>
							</div>
						</div>
					</div>
					<?php } ?>
					<div class="clear"></div>
					<? if ($is_logged_in && $current_user->is_valid) { ?>
					<div class="discussion_post_info">
							<div class="content">
								<?php
									$pic = site_url("assets/user_images/" . $current_user->picture);
									$pic = substr($pic, 0, strlen($pic)-4) . "_thumb.jpg";
								?>
								<a href="<?=site_url("users/profile/" . $current_user->id)?>"><img id="user_image" src="<?=$pic?>" /></a>
							</div>
					</div>
					<div class="discussion_newpost shadowed">
						<div class="inner-box">
							<div class="content">
								<a name="message"></a>
								<h4>Reply or post</h4>
								<p>
									Please note that it's a <a target="_blank" href="http://en.wikipedia.org/wiki/Markdown">markdown</a> editor!<br />
									If you dont know how to put <a href="#" class="md_help" id="md_code">Codes</a>, <a href="#" class="md_help" id="md_style">Styling (bold, italic etc)</a>, <a href="#" class="md_help" id="md_list">lists</a>, <a href="#" class="md_help" id="md_quotes">Blockquotes</a> and <a href="#" class="md_help" id="md_link">links</a> in markdown, click on that item!
								</p>
								<div class="md_help_desc md" id="md_code_desc">
									<p>To create code blocks or other preformatted text, indent by four spaces or tab:</p>
									<blockquote>
<pre>    This will be displayed in a monospaced font. The first four spaces
    will be stripped off, but all other whitespace will be preserved.
    
    Markdown and HTML are turned off in code blocks:
    _This is not italic_, and [this is not a link](http://example.com)</pre>
									</blockquote>
									<p>To create not a block, but an inline code span, use backticks (`):</p>
									<blockquote>
										<pre>Use `getline(cin, str)` to read the whole line.</pre>
									</blockquote>
									<p>If you want to have a preformatted block within a list, indent by eight spaces or two tabs:</p>
									<blockquote>
<pre>1. This is normal text.
2. So is this, but now follows a code block:
 
        Skip a line and indent eight spaces.
        That's four spaces for the list
        and four to trigger the code block.</pre>
									</blockquote>
								</div>
								<div class="md_help_desc md" id="md_style_desc">
									<p>Be sure to use text styling sparingly; only where it helps readability.</p>
									<blockquote>
<pre>*This is italicized*, and so is _this_.
**This is bold**, just like __this__.
You can ***combine*** them if you ___really have to___.</pre>
									</blockquote>

									<p>To break your text into sections, you can use headers:</p>
									<blockquote>
<pre>A Large Header
==============

Smaller Subheader
-----------------</pre>
									</blockquote>

									<p>Use hash marks if you need several levels of headers:</p>

									<blockquote>
<pre># Header 1 #
## Header 2 ##
### Header 3 ###</pre>
									</blockquote>
								</div>
								<div class="md_help_desc md" id="md_list_desc">
									<p>Bulleted lists are possible:</p>
									<blockquote>
<pre>- Use a minus sign for a bullet
+ Or plus sign
* Or an asterisk
</pre>
									</blockquote>
									<p>Numbered lists are also supported:</p>
									<blockquote>
<pre>1. Numbered lists are easy
2. Markdown keeps track of
   the numbers for you
7. So this will be item 3.</pre>
									</blockquote>
									<p>Indentation (tabs or spaces) is important:</p>
									<blockquote>
<pre>1. Lists in a list item:
    - Indented four spaces.
        * indented eight spaces.
    - Four spaces again.
2.  You can have multiple
    paragraphs in a list items.
    
    Just be sure to indent.</pre>
									</blockquote>
								</div>
								<div class="md_help_desc md" id="md_quotes_desc">
									<blockquote>
<pre>&gt; Create a blockquote by
&gt; prepending "&gt;" to each line.
&gt;
&gt; Other formatting also works here, e.g.
&gt;
&gt; 1. Lists or
&gt; 2. Headings:
&gt;
&gt; ## Quoted Heading ##</pre>
									</blockquote>
									<p>You can even put blockquotes in blockquotes:</p>
									<blockquote>
<pre>&gt; A standard blockquote is indented
&gt; &gt; A nested blockquote is indented more
&gt; &gt; &gt; &gt; You can nest to any depth.</pre>
									</blockquote>
								</div>
								<div class="md_help_desc md" id="md_link_desc">
									<p>In most cases, a plain URL will be recognized as such and automatically linked:</p>
									<blockquote>
										<pre>Use angle brackets to force linking: Have you seen &lt;http://sharecode.ir&gt?</pre>
									</blockquote>
									<p>To create fancier links, use Markdown:</p>
									<blockquote>
<pre>Here's [a link](http://sharecode.ir/)! And a reference-style link to [a problem][1].
References don't have to be [numbers][sharecode].
[1]: http://sharecode.ir/problemset/view/1001
[sharecode]: http://sharecode.ir</pre>
									</blockquote>
									<p>
									You can add tooltips to links:
									</p>
									<blockquote>
<pre>Click [here](http://sharecode.ir "this text appears when you mouse over")!
This works with [reference links][1001] as well.
[1001]: http://sharecode.ir/problemset/view/1001 "click to see the problem #1001"</pre>
									</blockquote>

								</div>
								
								<?=form_error('text','<br /><label></label><span class="error">* ','</span>');?>
								<span id="discussion_new_post_msg" class="error"></span>
								<pre id="editor"><?=set_value('text', $quoted_text)?></pre>
								
								<div id="md_prev" class="md">
									
								</div>
								
								<form id="discussion_new_form" method="post" action="<?=site_url("discussion/topic/" . $topic_head->id . "/" . $current_page . "/new")?>">
									<textarea class="nos" name="text" id="newpost_text"><?=set_value('text', $quoted_text)?></textarea>
									<input id="post_button" type="submit" value="Post"/>
								</form>
								<input type="hidden" name="ajax_problem_code" id="ajax_problem_code" value="<?=$problem->code?>" />
								<input type="hidden" name="ajax_topic_id" id="ajax_topic_id" value="<?=$topic_head->id?>" />
								<input type="hidden" name="ajax_user_name" id="ajax_user_name" value="<?=$current_user->name?>" />
								<input type="hidden" name="ajax_current_page" id="ajax_current_page" value="<?=$CURRENT_PAGE?>" />
								<input type="hidden" name="ajax_this_page" id="ajax_this_page" value="<?=$current_page?>" />
								
							</div>
						</div>
					</div>
					<? } else if ($is_logged_in && !$current_user->is_valid) { ?>
					<div class="discussion_login shadowed">
						<div class="inner-box">
							<div class="content">
								<span class="big">Validate your email address!</span><br />
								<p>In order to post something you must validate your email address first.</p>
							</div>
						</div>
					</div>
					<? } else { ?>
					<div class="discussion_login shadowed">
						<div class="inner-box">
							<div class="content">
								<span class="big">Login please!</span><br />
								<p>In order to post something you must login first. You can use the form in the top of this page.</p>
							</div>
						</div>
					</div>
					<? } ?>
				</div>
			</div>
		</div>
		