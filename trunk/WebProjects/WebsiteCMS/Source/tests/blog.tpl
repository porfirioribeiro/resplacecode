#{start:post}
<div>
	#{id}  <a href="blog.php?showPost=#{id}" title="#{title}">#{title}</a>
	<div>#{body}</div>
	<hr>
</div>
#{end:post}
#{start:comment}
<div>
	<div title="#{author}">#{author}</div>
	<div>#{body}</div>
</div>
#{end:comment}

#{start:showpost}
	<div>
		<div>My Blog</div>
		<br>
		<div>#{posts}</div>
		<div>#{comments}</div>
		<div>
			<form action="blog.php=submitComment">
				Name :<input type="text" name="name"><br>
				Comment:<textarea name="body"></textarea>
			</form>
		</div>
	</div>
#{end:showpost}

#{start:main}
	<div>
		<div>My Blog</div>
		<br>
		<div>#{posts}</div>
	</div>
#{end:main}