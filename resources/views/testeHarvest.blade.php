<html>
<head>
<title>Teste Harvest</title>

</head>

<body>

<?php 
echo $month;

$mondayTotal = 0;
$tuesdayTotal = 0;  
$wednesdayTotal = 0; 
$thursdayTotal = 0; 
$fridayTotal = 0; 

$totalHours = 0;


for($i = 0; $i  < count($harvestTimeInfo->time_entries); $i++) {
if($harvestTimeInfo->time_entries[$i]->spent_date == $monday) {
    $mondayTotal += $harvestTimeInfo->time_entries[$i]->hours;
    $totalHours += $harvestTimeInfo->time_entries[$i]->hours;

}
if($harvestTimeInfo->time_entries[$i]->spent_date == $tuesday) {
    $tuesdayTotal += $harvestTimeInfo->time_entries[$i]->hours;
    $totalHours += $harvestTimeInfo->time_entries[$i]->hours;

}
if($harvestTimeInfo->time_entries[$i]->spent_date == $wednesday) {
    $wednesdayTotal += $harvestTimeInfo->time_entries[$i]->hours;
    $totalHours += $harvestTimeInfo->time_entries[$i]->hours;

}
if($harvestTimeInfo->time_entries[$i]->spent_date == $thursday) {
    $thursdayTotal += $harvestTimeInfo->time_entries[$i]->hours;
    $totalHours += $harvestTimeInfo->time_entries[$i]->hours;

}
if($harvestTimeInfo->time_entries[$i]->spent_date == $friday) {
    $fridayTotal += $harvestTimeInfo->time_entries[$i]->hours;
    $totalHours += $harvestTimeInfo->time_entries[$i]->hours;

}


}


?>

<br>
<br>
<br>
<br>
<img src="{{$harvestProfile->avatar_url}}">
<br>
{{$harvestProfile->first_name}}
{{$harvestProfile->last_name}}
<br>
 {{$harvestProfile->email}} 

 <br>
 <br>

 This Week
 <br>
<?php 
echo $week;
?>
<br>
{{$totalHours}} of 40 hours
<br>
<br>

<table>
<tr>

<th>{{date( 'D', strtotime( 'monday this week'))}}
    <br>
    {{date( 'd F', strtotime( 'monday this week'))}}
</th>
<th>{{date( 'D', strtotime( 'tuesday this week'))}}
    <br>
    {{date( 'd F', strtotime( 'tuesday this week'))}}
</th>
<th>{{date( 'D', strtotime( 'wednesday this week'))}}
    <br>
    {{date( 'd F', strtotime( 'wednesday this week'))}}
</th>
<th>{{date( 'D', strtotime( 'thursday this week'))}}
    <br>
    {{date( 'd F', strtotime( 'thursday this week'))}}
</th>
<th>{{date( 'D', strtotime( 'friday this week'))}}
    <br>
    {{date( 'd F', strtotime( 'friday this week'))}}
</th>

</tr>



<tr>
<td>{{$mondayTotal}} hours</td>
<td>{{$tuesdayTotal}} hours</td>
<td>{{$wednesdayTotal}} hours</td>
<td>{{$thursdayTotal}} hours</td>
<td>{{$fridayTotal}} hours</td>
</tr>






</table>




</body>

</html>