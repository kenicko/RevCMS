<?php
/**
 * Error Handler (ORIGINAL — NOT PROPERLY SET UP)
 *
 * To put this in basic, this is a horrible syntax set up,
 * but this wasn't meant to be released anyway.
 *
 * You can change whatever you wan't, credits would be
 * appriciated
 */

/**
 * Sets the error handler to errorHandler function
 */
set_error_handler('errorHandler');

/**
 * Sets the exception handler to exceptionHandler function
 */
set_exception_handler('exceptionHandler');

	/**
	 * Return server global (array)
	 * @param string $global Global
	 */
	function ServerGlobal($global)
	{
		return $GLOBALS['_SERVER'][$global];
	}

	/**
	 * ErrorHandler writes out the error itself.
	 * @param  int 		$code    Error code
	 * @param  string 	$msg     Message
	 * @param  string 	$file    File
	 * @param  int 		$line    Line number
	 * @param  string 	$context Context
	 * @return bool
	 */
	function errorHandler($code, $msg, $file, $line, $context)
	{

		if(error_reporting() == 0 || ini_get('error_reporting') == 0) {
			return;
		}

		$date = date("D M Y", ServerGlobal('REQUEST_TIME'));
		$time = date("H:i:s", ServerGlobal('REQUEST_TIME'));

		$urgent = ServerGlobal('HTTP_USER_AGENT');
		$software = ServerGlobal('SERVER_SOFTWARE');
		$ipaddr = ServerGlobal('SERVER_ADDR');
		$port = ServerGlobal('SERVER_PORT');
		$path = ServerGlobal('SCRIPT_FILENAME');

		$uri = ServerGlobal('HTTP_HOST').ServerGlobal('REQUEST_URI');

		$__phpversion = "PHP " . PHP_VERSION . " (" . PHP_OS . ")";

		switch ($code) 
                {
                        case E_NOTICE:break;                  
			case E_USER_ERROR:
			case E_USER_WARNING:
				error_parser($code, $msg, $file, $line, $context, $date, $time, $urgent, $software, $ipaddr, $port, $path, $uri, $__phpversion);
                                $Rev = getInstance();
                                $Rev->write = false;
                        break;
		}

		return true;

		die();
	}

	/**
	 * Exception Handler writes out the exception (another style)
	 * @param  string $exception Exception
	 * @return bool
	 */
	function exceptionHandler($exception)
	{
                                $Rev = getInstance();
                                $Rev->write = false;
		$date = date("D M Y", ServerGlobal('REQUEST_TIME'));
		$time = date("H:i:s", ServerGlobal('REQUEST_TIME'));

			$urgent = ServerGlobal('HTTP_USER_AGENT');
			$software = ServerGlobal('SERVER_SOFTWARE');
			$ipaddr = ServerGlobal('SERVER_ADDR');
			$port = ServerGlobal('SERVER_PORT');
			$path = ServerGlobal('SCRIPT_FILENAME');

			$uri = ServerGlobal('HTTP_HOST').ServerGlobal('REQUEST_URI');

			$traceline = "#%s %s(%s): %s(%s)";

			$trace = $exception->getTrace();
			 foreach ($trace as $key => $stackPoint) {
				// I'm converting arguments to their type
				// (prevents passwords from ever getting logged as anything other than 'string')
				$trace[$key]['args'] = array_map('gettype', $trace[$key]['args']);
			}

			// build your tracelines
			$result = array();
			foreach ($trace as $key => $stackPoint) {
				$result[] = sprintf(
					$traceline,
					$key,
					$stackPoint['file'],
					$stackPoint['line'],
					$stackPoint['function'],
					implode(', ', $stackPoint['args'])
				);

				$result[] = '#' . ++$key . ' {main}';
			}

				$__class = get_class($exception);
				$__file = $exception->getFile();
				$__line = $exception->getLine();
				$__result = implode("\n", $result);
				$__message = $exception->getMessage();
				$__code = $exception->getCode();

		echo "<html>
<head>
	<title>Error</title>
	<style type=\"text/css\">

		*, html, body { margin:0; padding:0; }

		::selection {
			background-color:			hotpink;
			color:						white;
			text-shadow:				none;
		}

		body {
			background-color:			#232323;
			font-family:				\"ProFontWindows\", Monaco, Consolas, Courier, monospace;
			font-size:					12px;
			color:						#FFFFFF;
			text-shadow:				0 1px 0 rgba(0, 0, 0, .1);
		}

		#wrapper {

			margin:						20px 130px;
			margin-right:				15px;
			margin-bottom:				0;
		}

			div.datetime {
				background-color:		#343434;
				position:				absolute;
				left: 					0;
				padding:				5px 7px 5px 0;
				width:					95px;
				text-align:				right;
				color:					#969696;
			}

				div.datetime span {
					line-height:			14px;
				}

			span {
				display:				block;
				line-height:			18px;
			}

			span.uri {
				color:					#5b5b5b;
			}

			span.errorcode {
				color:					#c4ae55;
			}

				div.errormsg {
					margin:				20px 15px;
					display:			inline-block;
				}

				div.errormsg > span.msg {
					background-color:	#c4ae55;
					color:				#5f3a04;
					border-radius:		1999px;
					padding:			0 10px;
					text-shadow:		0 1px 0 rgba(255, 255, 255, .25);
					box-shadow:			0 1px 2px rgba(0, 0, 0, .2);
				}

				div.errormsg > span.linenum {
					color:				#6f6f6f;
					text-align:			right;
				}

			div.software_urgent {
				color:				#424242;
				display:			inline-block;

			}

				div.software_urgent > span.ipaddr {
					color:				#FFFFFF;
					text-align:			right;
					margin-top:			10px;
				}

	</style>
</head>
<body>

	<div id=\"wrapper\">

		<div class=\"datetime\">
			<span class=\"date\">{$date}</span>
			<span class=\"time\">{$time}</span>
		</div>

		<span class=\"uri\">{$uri}</span>
		<span class=\"uri\">{$__file}</span>
		<span class=\"errorcode\">{$__class} code {$__code}</span>

	<div id=\"roundup\">
		<div class=\"errormsg\">
		<span class=\"msg\">{$__message}</span>
		<span class=\"linenum\">at line {$__line}</span>
		</div>
	</div>

	<div id=\"roundup\">
		<div class=\"software_urgent\">
			<span class=\"urgent\">{$urgent}</span>
			<span class=\"software\">{$software}</span>
			<span class=\"ipaddr\">{$ipaddr}:{$port}</span>
		</div>
	</div>

	</div>

</body>
</html>";

		return true;
		die();
	}


	/**
	 * PRIVATE - Error parser (used for parsing error in handler)
	 * @param  int 		$code       Error code
	 * @param  string 	$msg        Message
	 * @param  string 	$file       File
	 * @param  int 		$line       Line
	 * @param  string 	$context    Context
	 * @param  string 	$date       Date
	 * @param  int  	$time       Time
	 * @param  string 	$urgent     Urgent (browser agent)
	 * @param  string 	$software   Software (Server-side)
	 * @param  string 	$ipaddr     IP-Address
	 * @param  int 		$port       Port
	 * @param  string 	$path       Path
	 * @param  string 	$uri        URI
	 * @param  string 	$phpversion PHP version
	 */
	function error_parser($code, $msg, $file, $line, $context, $date, $time, $urgent, $software, $ipaddr, $port, $path, $uri, $phpversion)
	{
		echo "<html>
                <head>
	<title>Error</title>
	<style type=\"text/css\">

		*, html, body { margin:0; padding:0; }

		::selection {
			background-color:			hotpink;
			color:						white;
			text-shadow:				none;
		}

		body {
			background-color:			#232323;
			font-family:				\"ProFontWindows\", Monaco, Consolas, Courier, monospace;
			font-size:					12px;
			color:						#FFFFFF;
			text-shadow:				0 1px 0 rgba(0, 0, 0, .1);
		}

		#wrapper {

			margin:						20px 130px;
			margin-right:				15px;
			margin-bottom:				0;
		}

			div.datetime {
				background-color:		#343434;
				position:				absolute;
				left: 					0;
				padding:				5px 7px 5px 0;
				width:					95px;
				text-align:				right;
				color:					#969696;
			}

				div.datetime span {
					line-height:			14px;
				}

			span {
				display:				block;
				line-height:			18px;
			}

			span.uri {
				color:					#5b5b5b;
			}

			span.errorcode {
				color:					#cf7272;
			}

				div.errormsg {
					margin:				20px 15px;
					display:			inline-block;
				}

				div.errormsg > span.msg {
					background-color:	#cf7272;
					color:				#783131;
					border-radius:		1999px;
					padding:			0 10px;
					text-shadow:		0 1px 0 rgba(255, 255, 255, .25);
					box-shadow:			0 1px 2px rgba(0, 0, 0, .2);
				}

				div.errormsg > span.linenum {
					color:				#6f6f6f;
					text-align:			right;
				}

			div.software_urgent {
				color:				#424242;
				display:			inline-block;

			}

				div.software_urgent > span.ipaddr {
					color:				#FFFFFF;
					text-align:			right;
					margin-top:			10px;
				}

	</style>
</head>
<body>

	<div id=\"wrapper\">

		<div class=\"datetime\">
			<span class=\"date\">{$date}</span>
			<span class=\"time\">{$time}</span>
		</div>

		<span class=\"uri\">{$uri}</span>
		<span class=\"uri\">{$path}</span>
		<span class=\"errorcode\">Error code {$code}</span>

	<div id=\"roundup\">
		<div class=\"errormsg\">
		<span class=\"msg\">{$msg} in {$file}</span>
		<span class=\"linenum\">at line {$line}</span>
		</div>
	</div>

	<div id=\"roundup\">
		<div class=\"software_urgent\">
			<span class=\"urgent\">{$urgent}</span>
			<span class=\"software\">{$software}</span>
			<span class=\"php\">{$phpversion}</span>
			<span class=\"ipaddr\">{$ipaddr}:{$port}</span>
		</div>
	</div>

	</div>

</body>
</html>";
        }
	/** Shitty shitty code,
	    Make me a sandwitch **/

?>