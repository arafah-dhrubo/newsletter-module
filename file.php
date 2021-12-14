<?php
class ModHelloWorldHelper
{
    protected $application;
    protected $input;
    protected $db;

    public function __construct(){
        $factory = JFactory;
        $this->application=$factory->getApplication();
        $input = new JInput;
        $this->db = factory->getDbo();
    }

    //Function for showing message
    public function showMessage(string $message, string $type)
    {
        return $this->application->enqueueMessage(JText::_($message), $type);
    }

    //Function for subscribe
    public function Subscribe()
    {
        $flag = 0;
        $post = $this->input->getArray($_POST);
        $name = $post["name"];
        $email = $post["email"];
        $query = $this->db->getQuery(true);

        $query
            ->select($this->db->quoteName(array('id', 'name', 'email')))
            ->from($this->db->quoteName('newsletter'));

        $this->db->setQuery($query);
        $result = $this->db->loadObjectList();

        //Checking if user email address is already added
        foreach ($result as $value) {
            if ($value->email === $email) {
                $this->showMessage('Email Already Exists', 'error');
                $flag = 1;
                break;
            }
        }

        //If user email is new then email address will be added
        if ($flag == 0) {
            $columns = array('name', 'email');
            $values = array($this->db->quote($name), $this->db->quote($email));
            $query->clear();

            //Query for insert into DB
            $query
                ->insert($this->db->quoteName('newsletter'))
                ->columns($this->db->quoteName($columns))
                ->values(implode(',', $values));

            $this->db->setQuery($query);
            $this->db->execute();
            $this->showMessage('Subscribed successfully', 'success');
        }
    }

    //Function for unsubscribe
    public function Unsubscribe()
    {
        $flag = 0;

        //Getting user input
        $input = $this->application->input;
        $email = $input->get('email', '', 'string');

        $query = $this->db->getQuery(true);

        //Retriving records from DB
        $query
            ->select($this->db->quoteName(array('id', 'name', 'email')))
            ->from($this->db->quoteName('newsletter'));

        $this->db->setQuery($query);
        $result = $this->db->loadObjectList();

        //Comparing records with input
        foreach ($result as $value) {
            if ($value->email === $email) {
                $flag = 1;
                $query->clear();

                //Condition for delete a record
                $conditions = array(
                    $this->db->quotename('id') . ' = ' .  $this->db->quote($value->id),
                    $this->db->quotename('name') . ' = ' .  $this->db->quote($value->name),
                    $this->db->quotename('email') . ' = ' .  $this->db->quote($value->email)
                );

                //Deleting record
                $query->delete($this->db->quoteName('newsletter'));
                $query->where($conditions);
                $this->db->setQuery($query);
                $this->db->execute();
                $this->showMessage('Unsubscribed successfully', 'success');
                break;
            }
        }

        if ($flag == 0) {
            $this->showMessage("Email Address Not Found", 'error');
        }
    }
}
