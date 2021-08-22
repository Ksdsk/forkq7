<!--sample of convering php variable to json and then js var-->
<?php

$connect = mysqli_connect("localhost", "root", "", "events");
$sql = "SELECT * FROM event2";

$result = mysqli_query($connect, $sql);

$json_array = array();

while($row = mysqli_fetch_assoc($result))
{
    $json_array[] = $row;
}

$var = json_encode($json_array);
?>

<script>
var events = '<?php echo $var ?>';
var e = JSON.parse(events);
console.log(e[0].date)
</script>