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
    <input type="text" name="name" style="width: 100%;" placeholder="Enter Your Name" required><br>
    <label for="">Email:</label><br>
    <input type="email" name="email" style="width: 100%;" placeholder="Enter Your Email" required><br>
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
$helper= new ModHelloWorldHelper;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method="";
    if($_POST["method"]=="delete"){
        $helper->Unsubscribe();
    }else{
        $helper->Subscribe();
    }
}


?>