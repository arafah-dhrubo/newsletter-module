<?php
class ModHelloWorldHelper
{
    public static function setUser()
    {
        $flag=0;
        $input = new JInput;
        $post = $input->getArray($_POST);
        $name = $post["name"];
        $email = $post["email"];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
            ->select($db->quoteName(array('id', 'name', 'email')))
            ->from($db->quoteName('newsletter'));

        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        foreach($result as $key=>$value){
            if($value->email===$email){
                echo "Email Already Exists";
                $flag = 1;
                break;
            }
        }
       if($flag==0){
        $columns = array('name', 'email');
        $values = array($db->quote($name), $db->quote($email));
        $query->clear();

        $query
            ->insert($db->quoteName('newsletter'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));

        $db->setQuery($query);
        $db->execute();
        echo "Subscribed successfully";
       }
        
    }
    // public static function getHello()
    // {
    //     $db = JFactory::getDbo();
    //     $query = $db->getQuery(true);

        
    //     return $result;
    // }
//     public static function deleteHello()
//     {
//         $input = JFactory::getApplication()->input;
// // $name = $input->get('name', '', 'string');
// $email = $input->get('email', '', 'string');
        
//         return $email;
//     }
}
