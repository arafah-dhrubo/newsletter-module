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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="w-full">
    <ul class="nav nav-pills nav-fill">
        <li class="active"><a data-toggle="pill" href="#subscribe">Subscribe</a></li>
        <li><a data-toggle="pill" href="#unsubscribe">Unsubscribe</a></li>
    </ul>

    <div class="tab-content">
        <div id="subscribe" class="tab-pane fade in active">
            <form action="" method="post">
                <label for="name">Name:</label><br>
                <input type="text" name="name" style="width: 100%;" id="name" placeholder="Enter Your Name" required><br>
                <label for="email">Email:</label><br>
                <input type="email" name="email" id="email" style="width: 100%;" placeholder="Enter Your Email" required><br>
                <br>
                <input type="submit" style="width: 100%;" value="Subscirbe">
            </form>
        </div>
        <div id="unsubscribe" class="tab-pane fade">
            <form action="" method="post">
                <label for="email">
                    <input name="method" type="hidden" value="delete" />Email:</label><br>
                <input type="email" name="email" style="width: 100%;" id ="email" placeholder="Enter Your Email to Unsubscribe"><br>
                <br>
                <input type="submit" style="width: 100%;" value="Unsubscirbe">
            </form>
        </div>

    </div>
</div>


<?php

$helper = new ModHelloWorldHelper;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST["method"] == "delete") {
        $helper->Unsubscribe();
    } else {
        $helper->Subscribe();
    }
}
$user = JFactory::getUser();
if ($user->authorise('core.admin')) {
    $emailList=$helper->allEmails();
    foreach($emailList as $key=>$value){
        echo $value->email;
        echo $value->is_subscribed=0?" unsubscribed ":" subscribed ";
    }
}
?>