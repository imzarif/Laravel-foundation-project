<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Exception;
use Log;
use SoapClient;

trait RPCTrait
{
    private function getAccessToken($url, $payload = array())
    {
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            Log::info("RPCTrait:getAccessToken response" . $response);
            curl_close($ch);
            $decodedResponse = json_decode($response);
            if (isset($decodedResponse->error)) {
                return array("status" => false);
            } else {
                return array(
                    "status" => true,
                    "access_token" => $decodedResponse->access_token,
                );
            }
        } catch (Exception $e) {
            Log::error("RPCTrait:getAccessToken" . $e->getMessage());
            return array("status" => false);

        }
    }

    private function getUserID($url, $accessToken, $spocEmail)
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer $accessToken",
                ),
            ));
            $response = curl_exec($curl);
            Log::info("RPCTrait:getUserID response" . $response);
            curl_close($curl);
            $decodedResponse = json_decode($response);
            if (isset($decodedResponse->error)) {
                return array("status" => false);
            } else {
                $userId = 0;
                if (count($decodedResponse)) {
                    foreach ($decodedResponse as $data) {
                        if ($data->usr_email === $spocEmail && $data->usr_status === 'ACTIVE') {
                            $userId = $data->usr_uid;
                            break;
                        } else {
                            $userId = 0;
                        }
                    }
                }
                return array(
                    "status" => $userId ? true : false,
                    "userId" => $userId,
                );
            }
        } catch (Exception $e) {
            Log::error("RPCTrait:getUserID response" . $e->getMessage());
            return array("status" => false);

        }
    }

    private function createCase($url, $payload, $accessToken)
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $accessToken,
                    'Content-Type: application/json',
                ),
            ));
            $response = curl_exec($curl);
            Log::info("RPCTrait:createCase response" . $response);
            curl_close($curl);
            $decodedResponse = json_decode($response);
            if (isset($decodedResponse->app_number)) {
                return array(
                    "status" => true,
                    "app_number" => $decodedResponse->app_number,
                    "app_uid" => $decodedResponse->app_uid,
                );

            } else {
                return array("status" => false);
            }

        } catch (Exception $e) {
            Log::error("RPCTrait:createCase" . $e->getMessage());
            return array("status" => false);

        }
    }

    private function uploadFile($url, $payload, $accessToken)
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $accessToken,
                    'Content-Type: multipart/form-data',
                ),
            ));
            $response = curl_exec($curl);
            Log::info("RPCTrait:uploadFile response " . $response);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return array(
                    "status" => false,
                    "errorMessage" => $err,
                );
            }
            $decodedResponse = json_decode($response);
            if (isset($decodedResponse->url)) {
                return array(
                    "status" => true,
                    "url" => $decodedResponse->url,
                );

            } else {
                return array("status" => false);
            }

        } catch (Exception $e) {
            Log::error("RPCTrait:createCase" . $e->getMessage());
            return array("status" => false);

        }
    }

    private function soapAPICall($storagePath, $serviceName, $data)
    {
        if ($serviceName === 'SI_PONumber_OB') {
            $param["PO_Number"] = $data;
        } elseif ($serviceName === 'SI_Non_PO_VendorInvoice_OB') {
            $param["Agreement"] = $data;
        } elseif ($serviceName === 'SI_TrackingNumber_OB') {
            $param = $data;
        } elseif ($serviceName === 'SI_Non_PO_TrackingNumberUpdate_OB') {
            $param = $data;
        } else {
            $response['success'] = false;
            return $response;
        }
        $client = new SoapClient($storagePath, array(
            'soap_version' => SOAP_1_1,
            'trace' => true,
            'login' => config('workflow.sap_user'),
            'password' => config('workflow.sap_password'),
        ));
        try {
            $apiResponse = $client->__soapCall($serviceName, array($param));
            Log::info("SOAPAPICall ServiceName $serviceName " . " Request : " . json_encode($param) . " Response : " . json_encode($apiResponse));
            if ($apiResponse->Response === 'Data Retrived Sucessfully' && (isset($apiResponse->PO_Number) || isset($apiResponse->Agreement))) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
            }
            $response['data'] = json_decode(json_encode($apiResponse), true);
            return $response;
        } catch (SoapFault $e) {
            Log::error("RPCTrait:soapAPICall SoapFault response " . $e->getMessage());
            $response['success'] = false;
            return $response;
        }
    }

    private function callSoapAPI($wsdlStoragePath, $serviceName, $payload)
    {
        if (!in_array($serviceName, ['SI_PONumber_OB', 'SI_Non_PO_VendorInvoice_OB', 'SI_TrackingNumber_OB',
            'SI_Non_PO_TrackingNumberUpdate_OB', 'SI_WorkCompletion_OB', 'SI_ServicePOWCCApproval_OB',
             'SI_POWCCApproval_OB', 'SI_Non_PO_WCC_Approval_OB'])) {
            $response['success'] = false;
            return $response;
        }
        try {
            $client = new SoapClient($wsdlStoragePath, array(
                'soap_version' => SOAP_1_1,
                'trace' => true,
                'login' => config('workflow.sap_user'),
                'password' => config('workflow.sap_password'),
            ));
            $apiResponse = $client->__soapCall($serviceName, array($payload));
            Log::info("SOAPAPICall ServiceName $serviceName " . " Request : " . json_encode($payload) . " Response : " . json_encode($apiResponse));
            $response['success'] = true;
            $response['data'] = $apiResponse;
            return $response;
        } catch (SoapFault $e) {
            Log::error("RPCTrait:soapAPICall SoapFault response " . $e->getMessage());
            $response['success'] = false;
            return $response;
        }
    }
}
