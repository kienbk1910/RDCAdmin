<?php

namespace Application\Controller;

use Application\Service\IndexServiceInterface;
use Application\Controller\BaseController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Authentication\AuthenticationService;
use Application\Model\Certificate;
use Application\Model\ManagerCertificate;
use Application\Model\CertificateListItem;
use Application\Model\ManagerCertificateListItem;
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

    public function adddetailAction() {
        $this->checkAdmin();
        $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Thêm Hồ Sơ Chứng Chỉ");
    
        $request = $this->getRequest();
        $certificates = $this->databaseService->getListCertificates();
        $certificate_error = array();
        $managerCertificate = new ManagerCertificate();
        if ($request->isPost()) {
            $certificate_type = $this->getRequest ()->getPost('certificate_type', null);
            $certificate_code = $this->getRequest ()->getPost('certificate_code', null);
            if (strlen($certificate_code) > 500) {
                $certificate_error['certificate_code'] = "Mã số chứng chỉ vượt quá giới hạn cho phép (500 kí tự)";
            } else if (strlen($certificate_code) <= 0) {
                $certificate_error['certificate_code'] = "Mã số chứng chỉ trống";
            }
            $full_name = $this->getRequest ()->getPost('full_name', null);
            if (strlen($full_name) > 50) {
                $certificate_error['full_name'] = "Tên khách hàng vượt quá giới hạn cho phép (50 kí tự)";
            } else if (strlen($full_name) <= 0) {
                $certificate_error['full_name'] = "Tên khách hàng trống";
            }
    
            $day_of_birth = $this->getRequest ()->getPost('day_of_birth', null);
            $place_of_birth = $this->getRequest ()->getPost('place_of_birth', null);
            $identity_card = $this->getRequest ()->getPost('identity_card', null);
            $start_time = $this->getRequest ()->getPost('start_time', null);
            $end_time = $this->getRequest ()->getPost('end_time', null);
            $date_of_issue = $this->getRequest ()->getPost('date_of_issue', null);
            /* validate certificate_code */
            $note = $this->getRequest ()->getPost('note', null);
            if (strlen($note) > 500) {
                $certificate_error['certificate_note'] = "Ghi chú của chứng chỉ vượt quá giới hạn cho phép (500 kí tự)";
            }

            if (empty($certificate_error)) {
                $managerCertificate->certificate_code = $certificate_code;
                $managerCertificate->certificate_type = $certificate_type;
                $managerCertificate->full_name = $full_name;
                $managerCertificate->day_of_birth = $day_of_birth;
                $managerCertificate->place_of_birth = $place_of_birth;
                $managerCertificate->identity_card = $identity_card;
                $managerCertificate->date_of_issue = $date_of_issue;
                $managerCertificate->start_time = $start_time;
                $managerCertificate->end_time = $end_time;
                $managerCertificate->last_user_id = $this->auth->getIdentity()->id;
                $managerCertificate->create_user_id = $this->auth->getIdentity()->id;
                $managerCertificate->note = $this->auth->getIdentity()->note;
                $ret = $this->databaseService->adddetailCertificate($managerCertificate);
    
                if ($ret == Config::CERTIFICATE_EXIST) {
                    $certificate_error['certificate_code'] = Config::CERTIFICATE_EXIST;
                } else {
                    return $this->redirect()->toRoute('manager-certificates/detailindex');
                }
            }
        }

        return new ViewModel(array(
                'certificates' => $certificates,
                'certificate_error' => $certificate_error,
                'managerCertificate' => $managerCertificate,
        ));
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

    public function getlistdetailAction(){
        $this->checkAuth();
        $request = $this->getRequest();
    
        $draw = $request->getPost('draw', 1);
        $start = $request->getPost('start', 0);
        $length = $request->getPost('length', 10);
        $search = $request->getPost('search', '');
        $search = $search['value'];
        $total = $this->databaseService->getTotalManagerCertificates();

        $certificates = $this->databaseService->getListManagerCertificatesAll($start,$length,$search);
        $data = new DataTablesObject();
        $data->recordsTotal = $total;
        $data->recordsFiltered = $this->databaseService->getCountManagerCertificates($search);
        $data->draw = $draw;
        foreach ($certificates as $certificate) {
            array_push($data->data, new ManagerCertificateListItem($certificate->id, $certificate->certificate_name, $certificate->full_name,
            $certificate->identity_card, $certificate->certificate_code));
        }
        echo \Zend\Json\Json::encode($data, false);
        exit;
    }
    
}