#{start:cell}
	<td>#{content}</td>
#{end:cell}
#{start:row}
	<tr>#{name}#{age}</tr>
#{end:row}
#{start:table}
	<table border='1'>
			<tr>
				<td>Name:</td><td>Age:</td>
			</tr>
			#{rows}
	</table>
#{end:table}
