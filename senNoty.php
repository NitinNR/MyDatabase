<?PHP


    function sendMessage(){
        $content = array(
            "en" => 'English Message',
            "title"=>"Bibel Live Church",
            "message"=>"Live on youTube"
            
            );
        
        /*$fields = array(
            'app_id' => "2d5fd8a9-4340-481e-9431-27b7cea1e773",
            'include_player_ids' => array("15331ccd-2ca8-45f1-aef3-0bb1eef91683"),
            'data' => array("foo" => "bar"),
            'contents' => $content
        );*/

         $fields = array(
        'app_id' => "2d5fd8a9-4340-481e-9431-27b7cea1e773",
        'included_segments' => array('All'),
        'data' => array("foo" => "bar"),
        'large_icon' =>"ic_launcher_round.png",
        'contents' => $content
    );
        
        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic NzgxMjVlZmMtMGYyZi00MTg3LWEzOGUtOWMyZWVkODdmODJi'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }


    if($_GET["dowork"]=="senNoty"){


            $response = sendMessage();
            $return["allresponses"] = $response;
            $return = json_encode( $return);
            
            print("\n\nJSON received:\n");
            print($return);
            print("\n");

    }
    
    
?>