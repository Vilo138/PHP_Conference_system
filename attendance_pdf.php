<?php
session_start();

// include autoloader
require_once 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

include_once('inc/config.php');
$currentDate = date('Y-m-d');
$dueDate = date('Y-m-d', strtotime('+2 weeks'));

$text = "
<style>
* {font-family: DejaVu Sans;}
td, th {padding: 2px 10px;}
th {background: #ffffaa}
</style>

<h1>Invoice Conference system </h1>
<table>
<thead>
    <tr>
        <th>First name</th>
        <th>Last name</th>
        <th>Registration fee</th>
        <th>Due date</th>
    </tr>
    </thead>
    <tbody>
    ";

$sql ='SELECT users.first_name, users.last_name, reg_fee.price FROM registration join users on registration.user_id = users.id join reg_fee on registration.reg_fee_id = reg_fee.id order by registration.id desc limit 1';
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_assoc($result))
    {
        $text.= "<tr>";
        $text.= "<td>" . $row["first_name"]. "</td>";
        $text.= "<td>" . $row["last_name"]. "</td>";
        $text.= "<td>" . $row["price"]. "</td>";
        $text.= "<td>" . $dueDate. "</td>";
        $text.= "</tr>";
    }
}
$text.= "</tbody></table>";
        


$dompdf->loadHtml($text);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait'); // portrait/landscape

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('Invoice.pdf');


