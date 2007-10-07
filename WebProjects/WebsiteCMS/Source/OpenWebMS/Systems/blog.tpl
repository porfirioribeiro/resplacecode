#{start:post}
<div>
	
	<div class="heading">#{del}<b><a href="blog.php?bp=#{id}" title="#{title}">#{title}</a></b></div>
	<div style="padding-left:3px">
	<i>Posted by #{userid} in category #{cat} on #{date}.</i><br>
	#{sub}</div>
	<br>
</div>
#{end:post}
#{start:addpost}
<div>
	<b>New blog post:</b><br><br>
	<form action="#{action}" method="POST">
		<input type="hidden" name="add">
		Category:<br>
		<select name="catid">
			#{CATS}
		</select>
		Title:<br><input type="text" name="title"><br><br>
		Description:<br><input type="text" name="des"><br><br>
		Body:<br>
		<textarea style="width:500px;height:120px" name="body"></textarea><br>
		<br><input type="submit" value="Save">
	</form>
</div>
#{end:addpost}
#{start:addcat}
<div>
	<b>New blog category:</b><br><br>
	<form action="#{action}" method="POST">
		<input type="hidden" name="add2">
		Title:<br><input type="text" name="title"><br><br>
		Description:<br><input type="text" name="des"><br><br>
		<input type="submit" value="Save">
	</form>
</div>
#{end:addcat}


#{start:main}
	<div>
		<div>Welcome to my blog, my blog posts are listed below with the most recent post at the top of the page for convienience. If you are logged in as an administrator you may also <a href="?add">post to the blog</a>:</div>
		<br>
		<div>#{posts}</div>
	</div>
#{end:main}
#{start:list}
		<div>#{posts}</div>
#{end:list}
#{start:cat}
	<div>
		<a href="?cat=#{id}" title="#{des}">#{title}</a>
	</div>
#{end:cat}
#{start:SelectCat}
	<option value="#{id}">#{name}</option>
#{end:SelectCat}
#{start:showing}
	<div>
		<div>#{showpost}</div>
		<div>&laquo;Back ^Top</div>
	</div>
#{end:showing}
#{start:showpost}
<div>
	<div style="float:right"><i>Posted by #{userid} #{cat} on #{date}.</i></div>
	<br><br>
	<div style="padding-left:3px">
	#{body}<br><br></div>
	<br>
</div>
#{end:showpost}