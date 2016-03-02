<?php

namespace Application\Controller;

use Application\Service\IndexServiceInterface;
use Application\Controller\BaseController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Authentication\AuthenticationService;
use Application\Model\Certificate;
use Application\Model\CertificateListItem;
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
        $this->getServiceLocator()->get( 'ViewHelperManager' )->get( 'HeadTitle' )->set( "Danh Sách Chứng Chỉ" );
        return new ViewModel();
    }
    
    public function detailindexAction() {
        $this->checkLevel2();
        $this->getServiceLocator()->get( 'ViewHelperManager' )->get( 'HeadTitle' )->set( "Danh Sách Hồ Sơ Chứng Chỉ" );
        return new ViewModel();
    }
    
    public function getlistAction(){
        $this->checkAuth();
        $request = $this->getRequest();
    
        $draw = $request->getPost('draw', 1);
        $start = $request->getPost('start', 0);
        $length = $request->getPost('length', 10);
        $search = $request->getPost('search', '');
        $search = $search['value'];
        $total = $this->databaseService->getTotalCertificates();
    
        $certificates = $this->databaseService->getListCertificatesAll($start,$length,$search);
        $data = new DataTablesObject();
        $data->recordsTotal = $total;
        $data->recordsFiltered = $this->databaseService->getCountCertificates($search);
        $data->draw = $draw;
        foreach ($certificates as $certificate) {
            $certificate->create_date = Date::changeDateSQLtoVN($certificate->create_date);
            array_push($data->data, new CertificateListItem($certificate->id, $certificate->certificate_name,
                $certificate->certificate_note, $certificate->last_user_id, $certificate->create_date));
        }
        echo \Zend\Json\Json::encode($data, false);
        exit;
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
                $ret = $this->databaseService->adddetailCertificate($certificate);
    
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
        $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Thêm Chứng Chỉ");

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

    public function editAction() {
        $this->checkAdmin();
        $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Chỉnh Sửa Chứng Chỉ");
    
        $request = $this->getRequest();
        $id = $this->params()->fromRoute( 'id', 0 );
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

                $certificate->last_user_id = $this->auth->getIdentity()->id;
                $certificate->id = $id;
                $ret = $this->databaseService->updateCertificate($certificate);
    
                if ($ret == NULL) {
                    $certificate_error['ng'] = "Chứng Chỉ Không Tồn Tại";
                } else {
                    $certificate_error['ok'] = "Chỉnh Sửa Chứng Chỉ Thành Công";
                }
            }
            return new ViewModel(array(
                    'certificate_error' => $certificate_error,
            ));
        } else {
            $ret = $this->databaseService->getCertificateByID($id)->current();
            
            if ($ret == NULL) {
                return $this->redirect()->toRoute('manager-certificates');
            } else {
                 return new ViewModel(array(
                    'certificate' => $ret,
            ));
            }
        }
    }
    
    public function editdetailAction() {
        $this->checkAdmin();
        $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Chỉnh Sửa Hồ Sơ Chứng Chỉ");
    
        $request = $this->getRequest();
        $id = $this->params()->fromRoute( 'id', 0 );
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
    
                $certificate->last_user_id = $this->auth->getIdentity()->id;
                $certificate->id = $id;
                $ret = $this->databaseService->updateCertificate($certificate);
    
                if ($ret == NULL) {
                    $certificate_error['ng'] = "Chứng Chỉ Không Tồn Tại";
                } else {
                    $certificate_error['ok'] = "Chỉnh Sửa Chứng Chỉ Thành Công";
                }
            }
            return new ViewModel(array(
                    'certificate_error' => $certificate_error,
            ));
        } else {
            $ret = $this->databaseService->getCertificateByID($id)->current();
    
            if ($ret == NULL) {
                return $this->redirect()->toRoute('manager-certificates');
            } else {
                return new ViewModel(array(
                        'certificate' => $ret,
                ));
            }
        }
    }
}