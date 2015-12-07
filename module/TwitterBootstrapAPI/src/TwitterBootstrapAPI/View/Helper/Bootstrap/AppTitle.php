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
class AppTitle extends AbstractHelper implements \Zend\ServiceManager\ServiceLocatorAwareInterface
{

    /**
     * View helper entry point:
     * Retrieves helper and optionally sets container to operate on
     *
     * @param  AbstractContainer $container [optional] container to operate on
     * @return self
     */
    public function __invoke($short = false)
    {
		return $this->render($short);
    }

	/**
	 * render nothing
	 * 
	 * @return string
	 */
	public function render($short = null)
	{
		$config = new \Zend\Config\Config( $this->getServiceLocator()->getServiceLocator()->get('Config') );
		if ($short === true) {
			return $config->get('app')->get('short_title');
		}
		return $config->get('app')->get('title');
	}
	
}