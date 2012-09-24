<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Helper
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Base url
 *
 * Base url can be called from a view or helper and can be used
 * as the following: 
 *
 * Example:
 * <code>
 *  <?php echo $this->baseUrl(string $url, boolean $ssl); ?>
 * </code>
 *
 * @package Bwork
 * @subpackage Bwork_Helper
 * @version v 0.2
 */
class Bwork_Helper_BaseUrl
{

    /**
     * Called by __call() at either a view or layout and is the main function of this helper
     *
     * @access public
     * @param String $url
     * @param Boolean $ssl
     * @return String Generated base url
     */
    public function baseUrl($url = null, $ssl = false)
    {
        return Bwork_Core_Registry::getInstance()->getResource('Bwork_Http_Request')->create($url, $ssl);
    }
    
}