<?php
namespace Application\Navigation\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class StaffNavigationFactory extends DefaultNavigationFactory
{
    protected function getName()
    {
        return 'staff';
    }
}