<?php
class ModHelloWorldHelper
{
    public static function setUser()
    {
        $input = new JInput;
        $post = $input->getArray($_POST);
        $name = $post["name"];
        $email = $post["email"];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
            ->select($db->quoteName(array('id', 'name', 'email')))
            ->from($db->quoteName('newsletter'));

        // $db->setQuery($query);
        $result = $db->loadObjectList();
        echo count($result);
        foreach($result as $key=>$value){
            echo "DB Value". $value->name;
            echo "Inserted value ${name}";
            if($value->name===$name or $value->email===$email){
                echo "Name or Email Already Exists";
                echo "DB Data".$value->name, "Inserted value".$name;
                break;
            }
        }
        $columns = array('name', 'email');
        $values = array($db->quote($name), $db->quote($email));
        $query->clear();

        $query
            ->insert($db->quoteName('newsletter'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));

        $db->setQuery($query);
        $db->execute();
        
    }
//     public static function getHello()
//     {
//         $db = JFactory::getDbo();
//         $query = $db->getQuery(true);

        
//         return $result;
//     }
//     public static function deleteHello()
//     {
//         $input = JFactory::getApplication()->input;
// // $name = $input->get('name', '', 'string');
// $email = $input->get('email', '', 'string');
        
//         return $email;
//     }
}
