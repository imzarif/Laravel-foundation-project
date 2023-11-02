<?php
return [
    'pm_server' => env('PM_SERVER'),
    'pm_workspace' => env('PM_WORKSPACE'),
    'pm_client_id' => env('PM_CLIENTID'),
    'pm_client_secret' => env('PM_CLIENTSECRET'),
    'pm_admin_user' => env('PM_ADMIN_USER'),
    'pm_admin_password' => env('PM_ADMIN_PASSWORD'),
    'grant_type' => env('GRANT_TYPE'),
    'scope' => env('SCOPE', '*'),
    'task_uid' => env('TASK_UID'),
    'process_uid' => env('PROCESS_UID'),
    'sap_user' => env('SAP_USER'),
    'sap_password' => env('SAP_PASSWORD'),
    'wsdl_location' => env('WSDL_LOCATION')
   # 'wsdl_location' => 'test-wsdl'
];
