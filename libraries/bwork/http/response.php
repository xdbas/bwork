<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Http
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Response
 *
 * This class will handle the response of the framework.
 *
 * @package Bwork
 * @subpackage Bwork_Http
 * @version v 0.1
 */
class Bwork_Http_Response
{

    /**
     * This will hold all the content assigned from the dispatcher which
     * retrieves its data from a controller
     *
     * @var string $body
     * @access public
     */
    public $body;

    /**
     * This will hold the content type for http response
     *
     * @var string $contentType
     * @access public
     */
    public $contentType = 'text/html';

    /**
     * This will hold the content charset type for the http response
     *
     * @var string
     */
    public $charset = 'UTF-8';

    /**
     * This will hold a status code possible set in a controller its default
     * value is 200
     *
     * @var int $statusCode
     * @access public
     */
    public $statusCode = 200;

    /**
     * This will hold the status message possible set in a controller its
     * default value is 'OK'
     *
     * @var string $statusMessage
     */
    public $statusMessage = 'OK';

    /**
     * This is een array with possible header statuses that will be used in the
     * set status function
     *
     * @var array $response
     * @access protected
     */
    protected $response = array(
        100 => 'Continue',
        101 => 'Switching Protocol',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choice',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'unused',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized ',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        415 => 'Unsupported Media',
        416 => 'Requested Range',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    );

    /**
     * This method is used to set the content ready for output
     *
     * @param mixed $content
     * @return Bwork_Http_Response
     */
    public function setBody($content)
    {
        $this->body = $content;

        return $this;
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @param string $charset
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
     * This function will attempt to set a status for the header information it
     * is possible to choose from the predefined array.
     *
     * @param int $code
     * @param string $description
     * @throws Bwork_Http_Exception
     * @access public
     * @return void
     */
    public function setStatus($code, $description = null)
    {
        if (array_key_exists($code, $this->response)) {
            $description = $this->response[$code];
        } else {
            if ($description === null) {
                throw new Bwork_Http_Exception(sprintf('Code not found, please define a description for [%s]', $code));
            }
        }

        $this->statusCode = $code;
        $this->statusMessage = $description;

        return $this;
    }

    /**
     * This will essentially use the status code and message to output header
     * information and echo the content.
     *
     * @access public
     * @return void
     */
    public function outputStatus()
    {
        header(sprintf('Content-Type: %s; charset=%s', $this->contentType, $this->charset));
        header(sprintf('HTTP/1.1 %d %s', $this->statusCode, $this->statusMessage));
        echo $this->body;
        exit;
    }

}