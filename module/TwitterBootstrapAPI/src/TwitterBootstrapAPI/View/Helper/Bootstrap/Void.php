<?php
/**
 * [MyApplication] (http://gitlab.dragon-projects.net:81/zf2/application-base)
 *
 * @link      http://gitlab.dragon-projects.net:81/zf2/application-base for the canonical source repository
 * @copyright Copyright (c) 2015 [dragon-projects.net] (http://dragon-projects.net)
 * @license   GPL
 */

namespace TwitterBootstrapAPI\View\Helper\Bootstrap;

/**
 *
 * render nothing
 *
 */
class Void extends AbstractHelper implements \Zend\ServiceManager\ServiceLocatorAwareInterface
{

    /**
     * View helper entry point:
     * Retrieves helper and optionally sets container to operate on
     *
     * @param  AbstractContainer $container [optional] container to operate on
     * @return self
     */
    public function __invoke($container = null)
    {
        if (null !== $container) {
            $this->setContainer($container);
        }

        return $this;
    }

	/**
	 * render nothing
	 * 
	 * @return string
	 */
	public function render($container = null)
	{
		$html = '';
		
		return $html;
	}

}