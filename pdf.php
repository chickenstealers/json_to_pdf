<?php

$json=file_get_contents('https://www.gumtrue.co.uk/api4/report_test.php?access_token=eyJ0eXAiOiJKV1QiLCAiYWxnIjoiSFMyNTYifQ.eyJqdGkiOiJ4VFVZaFwvVkhtNVRQTlRsSXVtOUtCUzhYUkxnRVd6NUROSWJcL3hFUWJVN1U9IiwiaXNzIjoiZ3VtdHJ1ZS5jby51ayIsImlhdCI6MTU1MTU0NDUzOSwibmJmIjoxNTUxNTQ0NTM5LCJleHAiOjE2MTQ2MTY1MzksImRhdGEiOnsiY2xpZW50SUQiOiJ0ZXN0Iiwic2Vzc2lvbklEIjozLCJjbGllbnRVc2VyTmFtZSI6ImQiLCJjbGllbnRQYXNzd29yZCI6ImQiLCJkYlNlcnZlciI6Imd1bXRydWUuY28udWsiLCJkYk5hbWUiOiJndW1tb2JpbGUiLCJkYlVzZXIiOiJndW1tb2JpbGUiLCJkYlBhc3N3b3JkIjoiR3VtdHJ1ZTIhIn19.gSwKMC_Gbut7vtRoVLu1wV-6q_BjQs7Nr9qHQnr6URM&roundNo=22');
$data =  json_decode($json);

//echo "<pre>"; print_r($data); echo "</pre>";
$input_data = $data->data;

//Function to get start and end of the week
$first_day_of_the_week = 'Sunday';
$start_of_the_week     = strtotime("Last $first_day_of_the_week");
if ( strtolower(date('l')) === strtolower($first_day_of_the_week) )
{
    $start_of_the_week = strtotime('today');
}
$end_of_the_week = $start_of_the_week + (60 * 60 * 24 * 7) - 1;
//$date_format =  'l jS \of F Y h:i:s A';
// This prints out Sunday 7th of December 2014 12:00:00 AM
$date_format =  'd M Y';
// This prints out 02 Mar 2019
// See PHP: date - Manual 
// for ways to format the date
//echo date($date_format, $start_of_the_week);
// This prints out Saturday 13th of December 2014 11:59:59 PM
//echo date($date_format, $end_of_the_week);
$endofweek = date($date_format, $end_of_the_week);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
          font-size: 14px;
        }
        td, th {
          padding: 8px;
          text-align: right;
        }
        tr {
          border-top: 1px solid #000000;
        }
        tr:first-child td {
          border-top: none !important;
        }
    </style>
</head>
<body>
    <?php if (count($input_data->records)) { ?>
    <table>
        <tr style="font-weight:bold;border:none;">
            <td colspan="2" style="text-align:center;font-size:25px;">Round Reconciliation Report
            </td>
            <td style="font-size:16px;">Week Ending: <?php echo $endofweek; ?></td>
        </tr>
        <tr style="font-weight:bold;font-size:18px;border-top:none;border-bottom:3px solid #000000;">
            <td width="25%" style="text-align:left">For TUE</td>
            <td style="text-align:center">
                <span style="padding:5px 20px;background-color:#464646;color:#fff;">Round: 001</span>
            </td>
            <td width="25%">Name: R 01</td>
        </tr>
    </table>
    <div>
    <table>
        <tr style="border:none;">
            <th style="text-align: left;">Code</th>
            <th style="text-align: left;" width="18%">Description</th>
            <th>Opening</th>
            <th>Booked</th>
            <th>Sales</th>
            <th>C. Ret. &<br/>Damages</th>
            <th>Depot<br/>Returns</th>
            <th>TRF+/-</th>
            <th>Theory</th>
            <th>Closing</th>
            <th>Diff(+/-)</th>
        </tr>
        <?php foreach ($input_data->records as $idx => $items) { ?>
            <?php if (count($items->products)) { 
                $sum = 0;
                foreach ($items->products as $pd => $product) { $sum += $product->Difference; ?>
        <tr>
            <td style="text-align: left;"><?php echo str_pad($product->ProductCode, 5, '0', STR_PAD_LEFT); ?></td>
            <td style="text-align: left;"><?php echo $product->ProductDescription; ?></td>
            <td><?php if ($product->Opening != null) {echo number_format($product->Opening, 2, '.', '');} else {echo "- -";} ?></td>
            <td><?php if ($product->Bookout != null) {echo number_format($product->Bookout, 2, '.', '');} else {echo "- -";} ?></td>
            <td><?php if ($product->Sales != null) {echo number_format($product->Sales, 2, '.', '');} else {echo "- -";} ?></td>
            <td><?php if ($product->CustomerReturns != null) {echo number_format($product->CustomerReturns, 2, '.', '');} else {echo "- -";} ?></td>
            <td><?php if ($product->Damages != null) {echo number_format($product->Damages, 2, '.', '');} else {echo "- -";} ?></td>
            <td><?php if ($product->Returns != null) {echo number_format($product->Returns, 2, '.', '');} else {echo "- -";} ?></td>
            <td><?php if ($product->Theory != null) {echo number_format($product->Theory, 2, '.', '');} else {echo "- -";} ?></td>
            <td><?php if ($product->Closing != null) {echo number_format($product->Closing, 2, '.', '');} else {echo "- -";} ?></td>
            <td><?php if ($product->Difference != null) {echo number_format($product->Difference, 2, '.', '');} else {echo "- -";} ?></td>
        </tr>
        <?php }} ?>
        <tr style="border-top: 3px solid #000000;font-weight:bold;">
            <td colspan="10" style="text-align:right;"><?php echo $items->Category; ?> Total : </td>
            <td style="text-align:right;"><?php echo number_format($sum, 2, '.', ''); ?></td>
        </tr>
        <tr style="border:none;">
            <td colspan="11" style>&nbsp;</td>
        </tr>
        <?php } ?>
        <?php 
            $total = 0;
            $sum = 0;
            foreach ($input_data->records as $idx => $items) {
                foreach ($items->products as $pd => $product){
                    $sum += $product->Difference;
                }
                $total += count($items->products);
            }
        ?>
        <tr style="border-top:4px solid #000000;font-weight:bold;font-size:16px;">
            <td style="text-align:left;">Total:</td>
            <td style="text-align:left;"><?php echo $total; ?> Product(s)</td>
            <td colspan="9"><?php echo $sum; ?></td>
        </tr>
    </table>
    </div>
    <div>
        <table>
            <tr style="border:none;">
                <td style="text-align:left;">Report Generated by Gumtrue and Printed on <?php echo date("d M Y h:i").' '.strtoupper(date("a")); ?></td>
                <td>Page 1 of 3</td>
            </tr>
        </table>
    </div>
    <?php } ?>
</body>

</html>