<?php
class VersionHistory extends Module {
	function VersionHistory($page){
		$this->side=Module::CENTER;
		$this->title="Version History";
		parent::Module($page);
	}
	function content(){
		global $WebMS;
		?>
		Version History is obtained from resplace.net servers, if it does not appear below then please try again later.<br><br>
		<div style="padding:10px;">
		<?php

		// get the host name and url path
		$parsedUrl = parse_url("http://resplace.net/WebMS/VersionHistory.php?verid=".$WebMS['Version']);
		$host = $parsedUrl['host'];
		if (isset($parsedUrl['path'])) {
			$path = $parsedUrl['path'];
		} else {
			// the url is pointing to the host like http://www.mysite.com
			$path = '/';
		}

		if (isset($parsedUrl['query'])) {
			$path .= '?' . $parsedUrl['query'];
		}

		if (isset($parsedUrl['port'])) {
			$port = $parsedUrl['port'];
		} else {
			// most sites use port 80
			$port = '80';
			}

			$timeout = 10;
			$response = '';

			// connect to the remote server
			$fp = @fsockopen($host, '80', $errno, $errstr, $timeout );

			if( !$fp ) {
				echo "Cannot retrieve $url";
			} else {
				// send the necessary headers to get the file
				fputs($fp, "GET $path HTTP/1.0\r\n" .
				"Host: $host\r\n" .
				"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3\r\n" .
				"Accept: */*\r\n" .
				"Accept-Language: en-us,en;q=0.5\r\n" .
				"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n" .
				"Keep-Alive: 300\r\n" .
				"Connection: keep-alive\r\n" .
				"Referer: http://$host\r\n\r\n");

				// retrieve the response from the remote server
				while ( $line = fread( $fp, 4096 ) ) {
				$response .= $line;
			}

			fclose( $fp );

			// strip the headers
			$pos      = strpos($response, "\r\n\r\n");
			$response = substr($response, $pos + 4);

			echo $response;
		}
		echo'</div>';
	}
}
$page->addModule("VersionHistory");
?>
