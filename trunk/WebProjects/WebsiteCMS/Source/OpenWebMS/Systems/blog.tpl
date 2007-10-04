#{start:post}
<div>
	<div class="heading"><b><a href="blog.php?bp=#{id}" title="#{title}">#{title}</a></b></div>
	<div style="padding-left:3px">
	<i>Posted by #{userid} on #{date}.</i><br>
	#{sub}</div>
	<br>
</div>
#{end:post}
#{start:addpost}
<div>
	<b>New blog post:</b><br><br>
	<form action="#{action}" method="POST">
		<input type="hidden" name="add">
		Title:<br><input type="text" name="title"><br><br>
		Description:<br><input type="text" name="des"><br><br>
		Body:<br>
		<textarea style="width:500px;height:120px" name="body"></textarea><br>
		<br><input type="submit" value="Save">
	</form>
</div>
#{end:addpost}
#{start:showpost}
<div>
	<div class="heading"><b><a href="blog.php?bp=#{id}" title="#{title}">#{title}</a></b></div>
	<div style="padding-left:3px">
	<i>Posted by #{userid} on #{date}.</i><br><br>
	#{body}</div>
	<br>
</div>
#{end:showpost}

#{start:main}
	<div>
		<div>Welcome to my blog, my blog posts are listed below with the most recent post at the top of the page for convienience. If you are logged in as an administrator you may also <a href="?add">post to the blog</a>:</div>
		<br>
		<div>#{posts}</div>
	</div>
#{end:main}

#{start:showing}
	<div>
		<div>#{showpost}</div>
		<div>&laquo;Back ^Top</div>
	</div>
#{end:showing}