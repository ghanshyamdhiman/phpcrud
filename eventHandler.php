<?php      
// Include database configuration file  
require_once 'dbConnect.php'; 
 
// Retrieve JSON from POST body 
$jsonStr = file_get_contents('php://input'); 
$jsonObj = json_decode($jsonStr); 
 
if($jsonObj->request_type == 'addEditUser'){ 
    $user_data = $jsonObj->user_data; 
    $fsr_id= !empty($user_data[0])?$user_data[0]:'';
    $fsr_date= !empty($user_data[1])?$user_data[1]:'';
    $fsr_slot= !empty($user_data[2])?$user_data[2]:'';
    $fsr_sch_fm= !empty($user_data[3])?$user_data[3]:'';
    $fsr_sch_till= !empty($user_data[4])?$user_data[4]:" ";
    $faculty= !empty($user_data[5])?$user_data[5]:" ";
    $lec_type= !empty($user_data[6])?$user_data[6]:" ";
    $act_code= !empty($user_data[7])?$user_data[7]:" ";
    $batch= !empty($user_data[8])?$user_data[8]:" ";
    $room= !empty($user_data[9])?$user_data[9]:" ";
    $chap_code= !empty($user_data[10])?$user_data[10]:" ";
    $fac_time_in= !empty($user_data[11])?$user_data[11]:" ";
    $fac_time_out= !empty($user_data[12])?$user_data[12]:" ";
    $attn_by= !empty($user_data[13])?$user_data[13]:" ";
    $attn_by_in= !empty($user_data[14])?$user_data[14]:" ";
    $attn_by_out= !empty($user_data[15])?$user_data[15]:" ";
    $remarks= !empty($user_data[16])?$user_data[16]:" ";
 
    $err = ''; 
    if(empty($fsr_id)){$err .= 'Please enter fsr_id<br/>';}
    if(empty($fsr_date)){$err .= 'Please enter fsr_date<br/>';}
    if(empty($fsr_slot)){$err .= 'Please enter fsr_slot<br/>';}
    if(empty($fsr_sch_fm)){$err .= 'Please enter fsr_sch_fm<br/>';}
    if(empty($fsr_sch_till)){$err .= 'Please enter fsr_sch_till<br/>';}
    if(empty($faculty)){$err .= 'Please enter faculty<br/>';}
    if(empty($lec_type)){$err .= 'Please enter lec_type<br/>';}
    if(empty($act_code)){$err .= 'Please enter act_code<br/>';}
    if(empty($batch)){$err .= 'Please enter batch<br/>';}
    if(empty($room)){$err .= 'Please enter room<br/>';}
    if(empty($chap_code)){$err .= 'Please enter chap_code<br/>';}
    if(empty($fac_time_in)){$err .= 'Please enter fac_time_in<br/>';}
    if(empty($fac_time_out)){$err .= 'Please enter fac_time_out<br/>';}
    if(empty($attn_by)){$err .= 'Please enter attn_by<br/>';}
    if(empty($attn_by_in)){$err .= 'Please enter attn_by_in<br/>';}
    if(empty($attn_by_out)){$err .= 'Please enter attn_by_out<br/>';}
    if(empty($remarks)){$err .= 'Please enter remarks<br/>';}
     
    if(!empty($user_data) && empty($err)){ 
        if(!empty($fsr_id)){ 
            // Update user data into the database 
            $sqlQ = "UPDATE tblfsr SET fsr_id=?, fsr_date=?, fsr_slot=?, fsr_sch_fm=?, fsr_sch_till=?, faculty=?, 
            lec_type=?, act_code=?, batch=?, room=?, chap_code=?, fac_time_in=?, fac_time_out=?, 
            attn_by=?, attn_by_in=?, attn_by_out=?, remarks=? WHERE fsr_id=?"; 
            $stmt = $conn->prepare($sqlQ); 
            $stmt->bind_param("ssssssssssssssssss", $fsr_id, $fsr_date, $fsr_slot, $fsr_sch_fm, $fsr_sch_till, $faculty, 
            $lec_type, $act_code, $batch, $room, $chap_code, $fac_time_in, $fac_time_out, 
            $attn_by, $attn_by_in, $attn_by_out, $remarks); 
            $update = $stmt->execute(); 
 
            if($update){ 
                $output = [ 
                    'status' => 1, 
                    'msg' => 'Member updated successfully!' 
                ]; 
                echo json_encode($output); 
            }else{ 
                echo json_encode(['error' => 'Member Update request failed!']); 
            } 
        }else{ 
            // Insert event data into the database 
            $sqlQ = "INSERT INTO tblfsr(fsr_id, fsr_date, fsr_slot, fsr_sch_fm, fsr_sch_till, faculty, 
            lec_type, act_code, batch, room, chap_code, fac_time_in, fac_time_out,
            attn_by, attn_by_in, attn_by_out, remarks) 
            value('$fsr_id','$fsr_date','$fsr_slot','$fsr_sch_fm','$fsr_sch_till','$faculty',
            '$lec_ type','$act_code','$batch','$room','$chap_code','$fac_time_in','$fac_time_out',
            '$attn_by','$attn_by_in','$attn_by_out','$remarks')"); 
            $stmt = $conn->prepare($sqlQ); 
            $stmt->bind_param("ssssssssssssssssss", $fsr_id, $fsr_date, $fsr_slot, $fsr_sch_fm, $fsr_sch_till, $faculty, 
            $lec_type, $act_code, $batch, $room, $chap_code, $fac_time_in, $fac_time_out, 
            $attn_by, $attn_by_in, $attn_by_out, $remarks); 
            $insert = $stmt->execute(); 
 
            if($insert){ 
                $output = [ 
                    'status' => 1, 
                    'msg' => 'Member added successfully!' 
                ]; 
                echo json_encode($output); 
            }else{ 
                echo json_encode(['error' => 'Member Add request failed!']); 
            } 
        } 
    }else{ 
        echo json_encode(['error' => trim($err, '<br/>')]); 
    } 
}elseif($jsonObj->request_type == 'deleteUser'){ 
    $fsr_id = $jsonObj->fsr_id; 
 
    $sql = "DELETE FROM tblfsr WHERE fsr_id=$fsr_id"; 
    $delete = $conn->query($sql); 
    if($delete){ 
        $output = [ 
            'status' => 1, 
            'msg' => 'Member deleted successfully!' 
        ]; 
        echo json_encode($output); 
    }else{ 
        echo json_encode(['error' => 'Member Delete request failed!']); 
    } 
}
?>
