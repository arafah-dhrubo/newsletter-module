<?php
class ModHelloWorldHelper
{
    //Function for adding new user's email
    public static function setUser()
    {
        $flag = 0;
        $application = JFactory::getApplication();
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

        //Checking if user email address is already added
        foreach ($result as $key => $value) {
            if ($value->email === $email) {
                $application->enqueueMessage(JText::_('Email Already Exists'), 'error');
                $flag = 1;
                break;
            }
        }

        //If user email is new then email address will be added
        if ($flag == 0) {
            $columns = array('name', 'email');
            $values = array($db->quote($name), $db->quote($email));
            $query->clear();

            $query
                ->insert($db->quoteName('newsletter'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));

            $db->setQuery($query);
            $db->execute();
            $application->enqueueMessage(JText::_('Subscribed successfully'), 'success');
        }
    }

    public static function deleteUser()
    {
        $flag = 0;
        $application = JFactory::getApplication();

        //Getting user input
        $input = JFactory::getApplication()->input;
        $email = $input->get('email', '', 'string');

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        //Retriving records from DB
        $query
            ->select($db->quoteName(array('id', 'name', 'email')))
            ->from($db->quoteName('newsletter'));

        $db->setQuery($query);
        $result = $db->loadObjectList();

        //Comparing records with input
        foreach ($result as $key => $value) {
            if ($value->email === $email) {
                $flag = 1;
                $query->clear();

                //Condition for delete a record
                $conditions = array(
                    $db->quotename('id') . ' = ' .  $db->quote($value->id),
                    $db->quotename('name') . ' = ' .  $db->quote($value->name),
                    $db->quotename('email') . ' = ' .  $db->quote($value->email)
                );

                //Deleting record
                $query->delete($db->quoteName('newsletter'));
                $query->where($conditions);
                $db->setQuery($query);
                $result = $db->execute();
                $application->enqueueMessage(JText::_('Unsubscribed successfully'), 'success');
                break;
            }
        }

        if ($flag == 0) {
            $application->enqueueMessage(JText::_("Email Address Not Found"), 'success');
        }
        // return $email;
    }
}
