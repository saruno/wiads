<?php

namespace AdvertiserBundle\Controller;

use AdvertiserBundle\AdvertiserBundle;
use AppBundle\Helper\Utils;
use Hotspot\AccessPointBundle\Helper\UtilHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Common\DbBundle\Model\Advert;
use Common\DbBundle\Model\AdvertQuery;
use AdvertiserBundle\Form\Type\AdvertiserType;
use Symfony\Component\HttpFoundation\Request;
use AdvertiserBundle\Helper\AdvertiserHelper;
use AdvertiserBundle\Helper\PaginationHelper;
use Common\DbBundle\Model\CustomerQuery;
use Propel\Runtime\Propel;
use Symfony\Component\HttpFoundation\Response;
use Hotspot\AccessPointBundle\Helper\ApConfigHelper;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CustomerController extends Controller
{
    public $result_export = '';

    public function report_adsAction(Request $request)
    {
        //giayst // giayst@report

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADS_REPORT')) {
            return $this->redirectToRoute('advertiser_login');
        }
        $user = $this->getUser();
        $username = $user->getUserName();
        $owner = '';
        $customer_id = '';

        $customer = CustomerQuery::create()->filterByUsername($username)->findOne();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')) {
            $owner = '';
            $customer_id = '';
        } elseif ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02') || $this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            $owner = $username;
        } else {
            $customer_id = $customer->getId();
            //$request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            //return $this->redirectToRoute('advertiser_notification_session');
        }
        if ($customer) {
            //$customer_id = $customer->getId();

            $submit = $request->get('submit', 0);
            $date_from = $request->get('date_from', 0);
            $date_to = $request->get('date_to', date('Y-m-d'));

            if ($date_from == 0) {
                $date_from = strtotime("-6 days", strtotime($date_to));
                $date_from = date('Y-m-d', strtotime(date("Y-m-d", $date_from)));
            }

            $result = '';

            if ($submit) {
                if (strtotime($date_from) <= strtotime($date_to)) {
                    $date_from = date('Y-m-d', strtotime($date_from));
                    $date_to = date('Y-m-d', strtotime($date_to));
                    if (!empty($customer_id))
                        $result = \AdvertiserBundle\Helper\AdvertiserHelper::getAdsReport($customer_id, array('from_0' => $date_from, 'to' => $date_to));
                    else {
                        $result = \AdvertiserBundle\Helper\AdvertiserHelper::getAdsReport($customer_id, array('from_0' => $date_from, 'to' => $date_to), $owner);
                    }
                } else {
                    $request->getSession()->getFlashBag()->add('error', 'Chọn ngày không hợp lệ!');
                }
            }

            return $this->render('AdvertiserBundle:Customer:report_ads.html.twig', array(
                'submit' => $submit,
                'customer_id' => $customer_id,
                'date_from' => date('d-m-Y', strtotime($date_from)),
                'date_to' => date('d-m-Y', strtotime($date_to)),
                'result' => $result,
            ));
        } else {
            return $this->redirectToRoute('advertiser_login');
        }
    }

    public function report_user_loginAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADS_REPORT')) {
            return $this->redirectToRoute('advertiser_login');
        }
        $user = $this->getUser();
        $username = $user->getUserName();
        $owner = '';
        $customer_id = '';
        $isAdmin = false;

        $customer = CustomerQuery::create()->filterByUsername($username)->findOne();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')) {
            $owner = '';
            $customer_id = '';
            $isAdmin = true;
        } elseif ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02') || $this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            $owner = $username;
        } else {
            $customer_id = $customer->getId();
            //$request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            //return $this->redirectToRoute('advertiser_notification_session');
        }
        if ($customer) {

            $submit = $request->get('submit', 0);
            $export_excel = $request->get('export-excel', 0);
            $date_from = $request->get('date_from', 0);
            $date_to = $request->get('date_to', date('Y-m-d'));
            $strUserAccesspoint = '';
            $recordUserAccesspoint = ApConfigHelper::getUserAccesspoint($username);
            foreach ($recordUserAccesspoint as $oneRecord) {
                $strUserAccesspoint .= "'" . $oneRecord['ap_macaddr'] . "'" . ",";
            }
            $strUserAccesspoint = substr($strUserAccesspoint, 0, -1);
            if ($date_from == 0) {
                $date_from = strtotime("-6 days", strtotime($date_to));
                $date_from = date('Y-m-d', strtotime(date("Y-m-d", $date_from)));
            }

            $result = '';
            if ($submit) {
                if (strtotime($date_from) <= strtotime($date_to)) {
                    $date_from = date('Y-m-d', strtotime($date_from));
                    $date_to = date('Y-m-d', strtotime($date_to));
                    if (!empty($customer_id))
                        $result = \AdvertiserBundle\Helper\AdvertiserHelper::getUserLoginReport($isAdmin, array('from_0' => $date_from, 'to' => $date_to), $strUserAccesspoint);
                    else {
                        $result = \AdvertiserBundle\Helper\AdvertiserHelper::getUserLoginReport($isAdmin, array('from_0' => $date_from, 'to' => $date_to), $strUserAccesspoint);
                    }
                } else {
                    $request->getSession()->getFlashBag()->add('error', 'Chọn ngày không hợp lệ!');
                }
            }
            if ($export_excel) {
                $this->export_user_loginAction($request);
            } else {
                return $this->render('AdvertiserBundle:Customer:report_user_login.html.twig', array(
                    'submit' => $submit,
                    'customer_id' => $customer_id,
                    'date_from' => date('d-m-Y', strtotime($date_from)),
                    'date_to' => date('d-m-Y', strtotime($date_to)),
                    'result' => $result,
                ));
            }
        } else {
            return $this->redirectToRoute('advertiser_login');
        }
    }

    public function export_user_loginAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADS_REPORT')) {
            return $this->redirectToRoute('advertiser_login');
        }
        $user = $this->getUser();
        $username = $user->getUserName();
        $owner = '';
        $customer_id = '';
        $isAdmin = false;

        $customer = CustomerQuery::create()->filterByUsername($username)->findOne();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')) {
            $owner = '';
            $customer_id = '';
            $isAdmin = true;
        } elseif ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02') || $this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            $owner = $username;
        } else {
            $customer_id = $customer->getId();
            //$request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            //return $this->redirectToRoute('advertiser_notification_session');
        }
        if ($customer) {
            $date_from = $request->get('date_from', 0);
            $date_to = $request->get('date_to', date('Y-m-d'));
            $strUserAccesspoint = '';
            $recordUserAccesspoint = ApConfigHelper::getUserAccesspoint($username);
            foreach ($recordUserAccesspoint as $oneRecord) {
                $strUserAccesspoint .= "'" . $oneRecord['ap_macaddr'] . "'" . ",";
            }
            $strUserAccesspoint = substr($strUserAccesspoint, 0, -1);
            if ($date_from == 0) {
                $date_from = strtotime("-6 days", strtotime($date_to));
                $date_from = date('Y-m-d', strtotime(date("Y-m-d", $date_from)));
            }

            $this->result_export = '';
            if (strtotime($date_from) <= strtotime($date_to)) {
                $date_from = date('Y-m-d', strtotime($date_from));
                $date_to = date('Y-m-d', strtotime($date_to));
                if (!empty($customer_id))
                    $this->result_export = \AdvertiserBundle\Helper\AdvertiserHelper::getUserLoginReport($isAdmin, array('from_0' => $date_from, 'to' => $date_to), $strUserAccesspoint);
                else {
                    $this->result_export = \AdvertiserBundle\Helper\AdvertiserHelper::getUserLoginReport($isAdmin, array('from_0' => $date_from, 'to' => $date_to), $strUserAccesspoint);
                }
            } else {
                    $request->getSession()->getFlashBag()->add('error', 'Chọn ngày không hợp lệ!');
            }
            $response = new StreamedResponse();
            $response->setCallback(function() {
                $handle = fopen('php://output', 'w+');

                // Add the header of the CSV file
                fputcsv($handle, array('STT', 'Facebook Id', 'Email/SĐT', 'Full Name', 'Wifi MacAddr', 'Ngày'),';');
                // Query data from database
                // Add the data queried from database
                $stt = 1;
                foreach ($this->result_export as $row){
                    fputcsv(
                        $handle, // The file pointer
                        array($stt, $row['uid'], row['email'], row['fullname'], row['ap_macaddr'], row['created_at']), // The fields
                        ';' // The delimiter
                    );
                    $stt++;
                }

                fclose($handle);
            });

            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
            $response->headers->set('Content-Disposition', 'attachment; filename="export_user_data.csv"');

            return $response;
        } else {
            return $this->redirectToRoute('advertiser_login');
        }
    }
}