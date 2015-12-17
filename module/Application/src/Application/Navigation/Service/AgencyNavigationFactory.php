<?php
namespace Application\Navigation\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class AgencyNavigationFactory extends DefaultNavigationFactory
{
    protected function getName()
    {
        return 'agency';
    }
}