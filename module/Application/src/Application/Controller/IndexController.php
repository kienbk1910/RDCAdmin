<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use DataTables\Editor,
    DataTables\Editor\Field,
    DataTables\Editor\Format,
    DataTables\Editor\Join,
    DataTables\Editor\Upload,
    DataTables\Editor\Validate;
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    public function statisticAction()
    {
        return new ViewModel();
    }
     public function testAction()
    {
        return new ViewModel();
    }
    public function staffAction()
    {
         $id =$this->params()->fromQuery('id');
        
    	include( "./vendor/Editor-PHP-1.5.4/php/DataTables.php" );
     Editor::inst( $db, 'datatables_demo' )->fields(
        Field::inst( 'first_name' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'last_name' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'position' ),
        Field::inst( 'email' ),
        Field::inst( 'office' ),
        Field::inst( 'extn' ),
        Field::inst( 'age' )
            ->validator( 'Validate::numeric' )
            ->setFormatter( 'Format::ifEmpty', null ),
        Field::inst( 'salary' )
            ->validator( 'Validate::numeric' )
            ->setFormatter( 'Format::ifEmpty', null ),
        Field::inst( 'start_date' )
            ->validator( 'Validate::dateFormat', array(
                "format"  => Format::DATE_ISO_8601,
                "message" => "Please enter a date in the format yyyy-mm-dd"
            ) )
            ->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
            ->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 )
    )
    ->process( $_POST )
    ->json(); 
    exit;
	}

    
}
