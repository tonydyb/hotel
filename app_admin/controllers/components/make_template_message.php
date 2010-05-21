<?php

App::import('Core', 'Multibyte');
class MakeTemplateMessageComponent extends Object{
/**
 * Layout for the View
 *
 * @var string
 * @access public
 */
	var $layout = 'default';
/**
 * Template for the view
 *
 * @var string
 * @access public
 */
	var $template = null;
/**
 * layout_directory
 *
 * @var string
 * @access public
 */
	var $layout_dir = '';
/**
 * as per RFC2822 Section 2.1.1
 *
 * @var integer
 * @access public
 */
	var $lineLength = 70;
/**
 * @deprecated see lineLength
 */
	var $_lineLength = null;
/**
 * charset the email is sent in
 *
 * @var string
 * @access public
 */
	var $charset = 'utf-8';
/**
 * If set, boundary to use for multipart mime messages
 *
 * @var string
 * @access private
 */
	var $__boundary = null;
/**
 * Temporary store of message lines
 *
 * @var array
 * @access private
 */
	var $__message = array();
/**
 * Initialize component
 *
 * @param object $controller Instantiating controller
 * @access public
 */
	function initialize(&$controller, $settings = array()) {
		$this->Controller =& $controller;
		if (Configure::read('App.encoding') !== null) {
			$this->charset = Configure::read('App.encoding');
		}
		$this->_set($settings);
	}
/**
 * Startup component
 *
 * @param object $controller Instantiating controller
 * @access public
 */
	function startup(&$controller) {}
/**
 * Send an email using the specified content, template and layout
 *
 * @param mixed $content Either an array of text lines, or a string with contents
 * @param string $template Template to use when sending email
 * @param string $layout Layout to use to enclose email body
 * @return boolean Success
 * @access public
 */
	function make_message($content = null, $template = null, $layout = null) {
		if ($template) {
			$this->template = $template;
		}

		if ($layout) {
			$this->layout = $layout;
		}

		if (is_array($content)) {
			$content = implode("\n", $content) . "\n";
		}

		$message = $this->__wrap($content);
		if ($this->template === null) {
			$message = $this->__formatMessage($message);
		} else {
			$message = $this->__renderTemplate($message);
		}

		$message[] = '';
		$this->__message = $message;

		if (!is_null($this->__boundary)) {
			$this->__message[] = '';
			$this->__message[] = '--' . $this->__boundary . '--';
			$this->__message[] = '';
		}

//		$this->__message = array();

		return $this->__message;
	}
/**
 * Reset all EmailComponent internal variables to be able to send out a new email.
 *
 * @access public
 */
	function reset() {
		$this->template = null;
		$this->__boundary = null;
		$this->__message = array();
	}
/**
 * Render the contents using the current layout and template.
 *
 * @param string $content Content to render
 * @return array Email ready to be sent
 * @access private
 */
	function __renderTemplate($content) {
		$viewClass = $this->Controller->view;

		if ($viewClass != 'View') {
			if (strpos($viewClass, '.') !== false) {
				list($plugin, $viewClass) = explode('.', $viewClass);
			}
			$viewClass = $viewClass . 'View';
			App::import('View', $this->Controller->view);
		}
		$View = new $viewClass($this->Controller, false);
		$View->layout = $this->layout;
		$msg = array();

		$content = implode("\n", $content);

		$content = $View->element($this->layout_dir . DS . $this->template, array('content' => $content), true);
		$View->layoutPath = $this->layout_dir;
		$content = explode("\n", str_replace(array("\r\n", "\r"), "\n", $View->renderLayout($content)));
		$msg = array_merge($msg, $content);

		return $msg;
	}
/**
 * Create unique boundary identifier
 *
 * @access private
 */
	function __createBoundary() {
		$this->__boundary = md5(uniqid(time()));
	}
/**
 * Format the message by seeing if it has attachments.
 *
 * @param string $message Message to format
 * @access private
 */
	function __formatMessage($message) {
		if (!empty($this->attachments)) {
			$prefix = array('--' . $this->__boundary);
			if ($this->sendAs === 'text') {
				$prefix[] = 'Content-Type: text/plain; charset=' . $this->charset;
			} elseif ($this->sendAs === 'html') {
				$prefix[] = 'Content-Type: text/html; charset=' . $this->charset;
			} elseif ($this->sendAs === 'both') {
				$prefix[] = 'Content-Type: multipart/alternative; boundary="alt-' . $this->__boundary . '"';
			}
			$prefix[] = 'Content-Transfer-Encoding: 7bit';
			$prefix[] = '';
			$message = array_merge($prefix, $message);
		}
		return $message;
	}
/**
 * Wrap the message using EmailComponent::$lineLength
 *
 * @param string $message Message to wrap
 * @return array Wrapped message
 * @access private
 */
	function __wrap($message) {
		$message = $this->__strip($message, true);
		$message = str_replace(array("\r\n","\r"), "\n", $message);
		$lines = explode("\n", $message);
		$formatted = array();

		if ($this->_lineLength !== null) {
			trigger_error('_lineLength cannot be accessed please use lineLength', E_USER_WARNING);
			$this->lineLength = $this->_lineLength;
		}

		foreach ($lines as $line) {
			if (substr($line, 0, 1) == '.') {
				$line = '.' . $line;
			}
			$formatted = array_merge($formatted, explode("\n", wordwrap($line, $this->lineLength, "\n", true)));
		}
		$formatted[] = '';
		return $formatted;
	}
/**
 * Encode the specified string using the current charset
 *
 * @param string $subject String to encode
 * @return string Encoded string
 * @access private
 */
	function __encode($subject) {
		$subject = $this->__strip($subject);

		$nl = "\r\n";
		if ($this->delivery == 'mail') {
			$nl = '';
		}
		return mb_encode_mimeheader($subject, $this->charset, 'B', $nl);
	}
/**
 * Remove certain elements (such as bcc:, to:, %0a) from given value
 *
 * @param string $value Value to strip
 * @param boolean $message Set to true to indicate main message content
 * @return string Stripped value
 * @access private
 */
	function __strip($value, $message = false) {
		$search  = '%0a|%0d|Content-(?:Type|Transfer-Encoding)\:';
		$search .= '|charset\=|mime-version\:|multipart/mixed|(?:[^a-z]to|b?cc)\:.*';

		if ($message !== true) {
			$search .= '|\r|\n';
		}
		$search = '#(?:' . $search . ')#i';
		while (preg_match($search, $value)) {
			$value = preg_replace($search, '', $value);
		}
		return $value;
	}
}
?>
