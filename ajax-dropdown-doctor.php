<?php

$conn = mysqli_connect('localhost', 'root', '', 'hcc_db') or die("Unable to connect" . mysqli_connect_error());

$nameid = $_POST['datapost'];

$sql = "SELECT * FROM doctor
    	WHERE department_id=$nameid";

$res = mysqli_query($conn, $sql);

while ($rows = mysqli_fetch_array($res)) {
?>

    <option value="<?php echo $rows['doctor_id']; ?>"><?php echo $rows['first_name'] . " " . $rows['last_name']; ?></option>

<?php

}


?>