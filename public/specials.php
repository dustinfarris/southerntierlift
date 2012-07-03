<?php

include('./db_connect.php');
include('./header.php');

?>
<div id="content">
<p>Southern Tier Lift is in the business of preventative maintenance. A key component to PMs is the ability to fix things when they are
    cost effective instead of paying 3 times as much to have it next day. Thats where our monthly specials are here to help. Around once
    a month we offer new monthly specials that allow you to replace parts that need to be replaced for cheaper. One of the most expensive
    parts of the material handling business is downtime. Downtime is inefficient because you still have to pay your employee's and on top
    of that, most likely your customers are not paying you to not doing anything while your forklift is broken. So what's the solution then?
    Fix it before it breaks. If you know you are going to need new forks in the next three months, the seat on your truck is ripped and torn
    or the strobes and backup alarm don't work, replace it while it is on sale.
</p>

<?php
$sql = "SELECT jsonItems FROM specials WHERE active = 1;";

$row = mysql_fetch_row(mysql_query($sql));

if($row) {
    $array = json_decode($row[0]);
    echo "<table>
            <thead>
                <tr>
                    <td>Monthly Specials</td>
                    <td>Standard Services</td>
                </tr>
            </thead>
            <tbody>
                <tr><td>";
                foreach ($array as $item) {
                    echo "<p><a href=\"".$item->link."\" title=\"".$item->sku."\">".$item->sku."</a></p>";
                }
          echo "</td>
                <td>
                    <p><a href=\"./tirepressing.php\">Mobile Tire Pressing</a></p>
                    <p><a href=\"./training.php\">OSHA Certified Operator Training Programs</a></p>
                    <p>Planned Maintenance Programs</p>
                    <p>Fleet Evaluations</p>
                    <p><a href=\"./trucks.php\">Reconditioned Forklifts</a></p>
                </td>
              </tr>
            </tbody>
          </table>";
}

?>

In addition to these monthly specials, Southern Tier Lift offers the area's best mobile tire pressing service and preventative maintenance.

</div>
<?php
include('./footer.php');?>
