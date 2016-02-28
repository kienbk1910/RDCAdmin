<?php

namespace Application\Controller;

use Application\Service\IndexServiceInterface;
use Application\Controller\BaseController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Authentication\AuthenticationService;
use Application\Model\Certificate;
use Application\Model\UserListItem;
use Application\Model\DataTablesObject;
use Zend\Debug\Debug;
use Application\Config\Config;
use Utility\Date\Date;

class ManagerCertificatesController extends BaseController {
    public function __construct(IndexServiceInterface $databaseService, AuthenticationService $auth) {
        $this->databaseService = $databaseService;
        $this->auth = $auth;
        $this->user = $auth->getIdentity();
    }
    public function indexAction() {
        $this->checkLevel2();
        $this->getServiceLocator()->get( 'ViewHelperManager' )->get( 'HeadTitle' )->set( "Danh Sách Hồ Sơ Chứng Chỉ" );
        return new ViewModel();
    }

    public function adddetailAction() {
        $this->checkAdmin();
        $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Thêm Hồ Sơ Chứng Chỉ");

        $request = $this->getRequest();
        $certificates = $this->databaseService->getListCertificates();
        $certificate_error = array();

        if ($request->isPost()) {
            $certificate_name = $this->getRequest ()->getPost('certificate_name', null);
            if (strlen($certificate_name) > 500) {
                $certificate_error['certificate_name'] = "Tên chứng chỉ vượt quá giới hạn cho phép (500 kí tự)";
            } else if (strlen($certificate_name) <= 0) {
                $certificate_error['certificate_name'] = "Tên chứng chỉ trống";
            }
    
            /* validate certificate_code */
            $certificate_note = $this->getRequest ()->getPost('certificate_note', null);
            if (strlen($certificate_note) > 500) {
                $certificate_error['certificate_note'] = "Ghi chú của chứng chỉ vượt quá giới hạn cho phép (500 kí tự)";
            }
    
            $certificate = new Certificate();
            if (empty($certificate_error)) {
                $certificate->certificate_name = $certificate_name;
                $certificate->certificate_note = $certificate_note;
    
                $certificate->create_user_id = $this->auth->getIdentity()->id;
                $certificate->last_user_id = $this->auth->getIdentity()->id;
                $ret = $this->databaseService->addCertificate($certificate);
    
                if ($ret == NULL) {
                    $certificate_error['certificate_name'] = "Chứng Chỉ Đã Tồn Tại";
                } else {
                    return $this->redirect()->toRoute('manager-certificates');
                }
            }
        }
        
        return new ViewModel(array(
                'certificates' => $certificates,
                'certificate_error' => $certificate_error,
        ));
    }
    
    public function addAction() {
        $this->checkAdmin();
        $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Thêm Hồ Sơ Chứng Chỉ");

        $request = $this->getRequest();
        if ($request->isPost()) {
            $certificate_name = $this->getRequest ()->getPost('certificate_name', null);
            $certificate_error = array();
            if (strlen($certificate_name) > 500) {
                $certificate_error['certificate_name'] = "Tên chứng chỉ vượt quá giới hạn cho phép (500 kí tự)";
            } else if (strlen($certificate_name) <= 0) {
                $certificate_error['certificate_name'] = "Tên chứng chỉ trống";
            }

            /* validate certificate_code */
            $certificate_note = $this->getRequest ()->getPost('certificate_note', null);
            if (strlen($certificate_note) > 500) {
                $certificate_error['certificate_note'] = "Ghi chú của chứng chỉ vượt quá giới hạn cho phép (500 kí tự)";
            }

            $certificate = new Certificate();
            if (empty($certificate_error)) {
                $certificate->certificate_name = $certificate_name;
                $certificate->certificate_note = $certificate_note;

                $certificate->create_user_id = $this->auth->getIdentity()->id;
                $certificate->last_user_id = $this->auth->getIdentity()->id;
                $ret = $this->databaseService->addCertificate($certificate);

                if ($ret == NULL) {
                    $certificate_error['certificate_name'] = "Chứng Chỉ Đã Tồn Tại";
                } else {
                    return $this->redirect()->toRoute('manager-certificates');
                }
            }
            return new ViewModel(array(
                    'certificate_error' => $certificate_error,
            ));
        }
        return new ViewModel();
    }
}