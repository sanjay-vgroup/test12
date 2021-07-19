<?php

namespace Vgroup\SafetyHubApp\Controller;

class Notifications extends \Magento\Framework\App\Action\Action {

    protected $_pageFactory;

    public function __construct(
	    \Magento\Framework\App\Action\Context $context,
	    \Magento\Framework\View\Result\PageFactory $pageFactory) {
	$this->_pageFactory = $pageFactory;
	return parent::__construct($context);
    }

//    public function send() {
//        
//	$resultPage = $this->_pageFactory->create();
//	$resultPage->getConfig()->getTitle('Send notifications');
//	return $resultPage;
//    }
 public function execute(){
     echo 'test';exit;
       $deviceToken='c8pkFHtx1nw:APA91bGqS4aVcpAxuiaYeC7N8MqpSlG0faRjKwulusXfPZ39Z4kYC0ctuKLvqRVgJFGTDhNwjwVrhow265oaVa_Xy57SZJt0g9k8rN3nJbWIpXapy0Wy2hbX7FELxzOmduNnPWvWSzlD';
//        define('API_ACCESS_KEY', 'AAAA5qnWEp0:APA91bHGg7tGGRuEEaD1ECcs_SkFzYSkRoOv9s_VNmKCyPgMdyYmaFriq3prIiAGkdHG9GdWVWZ31W53zDShcHwRCz7luvkNsxm07jiB8h-Brhs67HytlMrgAldec2rPasjWfkArm9sy');
//        $registrationIds = array($deviceToken);
//                $msg = array
//                    (
//                    'message' => 'cabinet expired',
//                    'category' => "Cabinet Reminder",
//                    'vibrate' => 1,
//                    'sound' => 1,
//                    //"silent" => true,
//                    'largeIcon' => 'large_icon',
//                    'smallIcon' => 'small_icon'
//                );
//                $fields = array
//                    (
//                    'registration_ids' => $registrationIds,
//                    'data' => $msg
//                );
//
//                $headers = array
//                    (
//                    'Authorization: key=' . API_ACCESS_KEY,
//                    'Content-Type: application/json'
//                );
//
//                $ch = curl_init();
//                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//                curl_setopt($ch, CURLOPT_POST, true);
//                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//                echo $result = curl_exec($ch);
//                curl_close($ch);exit;
//                
        try{
            $deviceToken='dad7cdc7d2d80b352a7364422c48c9066ed219cd31f603bd7af9da2a2deecd1f';
                $ctx = stream_context_create();
            // ck.pem is your certificate file
            stream_context_set_option($ctx, 'ssl', 'local_cert', 'Production_Push_Cer.pem');
            stream_context_set_option($ctx, 'ssl', 'passphrase', 'Vgroup1234');

            // Open a connection to the APNS server
            $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
            if (!$fp)
                exit("Failed to connect: $err $errstr" . PHP_EOL);
            // Create the payload body
            //{"aps":{"alert":"Testing.. (0)","badge":1,"sound":"default"}}
            
            $body['aps'] = array('alert' => 'Testing.. (0)', 'badge' => 1, 'sound' => 'default');
            // Encode the payload as JSON
            $payload = json_encode($body);
            // Build the binary notification
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
            // Send it to the server
            $result = fwrite($fp, $msg, strlen($msg));

            // Close the connection to the server
            fclose($fp);
            if (!$result)
                echo 'Message not delivered' . PHP_EOL;
            else
                echo 'Message successfully delivered' . PHP_EOL;
        } catch (Exception $es) {
            echo $es->getMessage();
        }
                exit;
        
	
    }
}
