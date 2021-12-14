<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_instagram
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<form action="" method="post">
    <label for="">Name:</label><br>
    <input type="text" name="name" style="width: 100%;" placeholder="Enter Your Name"><br>
    <label for="">Email:</label><br>
    <input type="email" name="email" style="width: 100%;" placeholder="Enter Your Email"><br>
    <br>
    <input type="submit" style="width: 100%;" value="Subscirbe">
</form>
<hr>
<form action="" method="post">
    <label for="">
        <input name="method" type="hidden" value="delete" />Email:</label><br>
    <input type="email" name="email" style="width: 100%;" placeholder="Enter Your Email to Unsubscribe"><br>
    <br>
    <input type="submit" style="width: 100%;" value="Unsubscirbe">
</form>
<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ModHelloWorldHelper::setUser();
}

// if ($_SERVER['REQUEST_METHOD'] === 'GET') {

//     $data = ModHelloWorldHelper::getHello();
    // echo gettype($value);

//     echo "<table>
//     <thead>
//         <th>#</th>
//         <th>Name</th>
//         <th>Email</th>
//     </thead>
//     <tbody>";
//     echo "<hr><h2>Results</h2>";
//     foreach ($data as $key => $value) {
//         echo "<tr>";
//         echo "<td>" . $key . "</td>";
//         echo "<td>" . $value->name . "</td>";
//         echo "<td>" . $value->email . "</td>";
//         echo "</tr>";
//     }
//     echo "</tbody>
// </table>";
// }
// if ($_SERVER['REQUEST_METHOD'] === 'delete') {
//     $data = ModHelloWorldHelper::deleteHello();
//     // $data = ModHelloWorldHelper::getHello();
// }
?>