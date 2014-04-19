<?php
namespace Bwork\Bootstrap;

    /**
     * Bwork Framework
     *
     * @package Bwork
     * @subpackage Bwork_Bootstrap
     * @author Bas van Manen <basje1[at]gmail.com>
     * @version $id: Bwork Framework v 0.1
     * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
     */

/**
 * AbstractBootstrap
 *
 * This class will execute all class methods starting with _init from its
 * children and will when its return type equals an object add it to the
 * Registry.
 *
 * @package Bwork
 * @subpackage Bwork_Bootstrap
 * @version v 0.2
 * @abstract
 */
abstract class Bootstrap
{

    /**
     * The construction method that handles the class function
     *
     * @access public
     * @throws \Exception
     * @return \Bwork\Bootstrap\Bootstrap
     */
    public function __construct()
    {
        $methods = get_class_methods($this);

        foreach ($methods as $key => $value) {
            if (substr(strtolower($value), 0, 5) == '_init') {

                $methodReflection = new ReflectionMethod($this, $value);
                $returnData = $methodReflection->invoke($this);

                if ($returnData !== null) {
                    if (is_object($returnData) === false) {
                        throw new \Exception(sprintf(
                            'The return data of %s should be either null or an object.',
                            $value
                        ));
                    }

                    if ($returnData instanceof Bwork_Bootstrap_Alias) {
                        Bwork_Core_Registry::getInstance()->setResource(
                            $returnData->object,
                            $returnData->name,
                            $returnData->override
                        );
                    } else {
                        Bwork_Core_Registry::getInstance()->setResource($returnData);
                    }
                }

            }
        }

    }

}