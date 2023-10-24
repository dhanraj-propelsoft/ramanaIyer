<?php
require_once("include/config.php");
if (!empty($_POST["contactno"])) {
	$contactno = $_POST["contactno"];
	$result = mysqli_query($con, "SELECT * FROM users WHERE contactno LIKE '%$contactno%'");
	$count = mysqli_num_rows($result);

    $datas = array();
    $ictr = 1;
    $data = "";
    $userType = "Offline User";
    if($count != 0) {
        $data .= '<table cellpadding="0" cellspacing="0" border="0"
            class="table table-striped display"
            style="width:100%;padding:5px;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Shipping Address</th>
                        <th>User Type</th>
                    </tr>
                </thead>
                <tbody>';
        while ($row = mysqli_fetch_array($result)) {
            $result1 = mysqli_query($con, "SELECT * FROM userlog WHERE userEmail='".$row['email']."'");
            $count1 = mysqli_num_rows($result1);
            if($count1 > 0)
                $userType = "Online User";
            else
                $userType = "Offline User";

            $adrs = $row['shippingAddress'] .', '. $row['shippingState'] .', '. $row['shippingCity'] .', '. $row['shippingPincode'];
            
            $ut = str_replace(" ", "_", $userType);
            $data .= '<tr style="cursor: pointer" onclick="window.location.href = \'profile-sec.php?id='.$row['id'].'&ut='.$ut.'\'">
                        <td>'.$ictr.'</td>
                        <td class="wrap_td_100">'.$row['name'].'</td>
                        <td class="wrap_td_100">'.$row['contactno'].'</td>
                        <td class="wrap_td_100">'.$row['email'].'</td>
                        <td class="wrap_td_100">'.$adrs.'</td>
                        <td class="wrap_td_100">'.$userType.'</td>
                    </tr>';    
            $ictr++;            
        }
        $data .= '</tbody>
        </table>';
        $data .= "<script>document.getElementById('addNewBtn').disabled = true;</script>";
    } else {
        if(strlen($contactno) == 10)
            $data .= "<script>document.getElementById('addNewBtn').disabled = false;</script>";
        else
            $data .= "<script>document.getElementById('addNewBtn').disabled = true;</script>";
    }
    echo $data;
}
?>