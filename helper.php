<?php
class ModHelloWorldHelper
{
    protected $application;
    protected $input;
    protected $db;
    public function __construct()
    {
        $this->application = JFactory::getApplication();
        $this->input = new JInput;
        $this->db = JFactory::getDbo();
    }

    //Function for showing message
    public function showMessage(string $message, string $type)
    {
        return $this->application->enqueueMessage(JText::_($message), $type);
    }

    //Function for showing all email address
    public function allEmails()
    {
        $query = $this->db->getQuery(true);

        $query
            ->select($this->db->quoteName(array('email', 'is_subscribed')))
            ->from($this->db->quoteName('d7oom_newsletter'));

        $this->db->setQuery($query);
        $result = $this->db->loadObjectList();
        return $result;
    }

    //Function for adding new user's email and mark as subscribe
    public function Subscribe()
    {
        $flag = 0;
        $post = $this->input->getArray($_POST);
        $name = $post["name"];
        $email = $post["email"];
        $is_subscribed = 1;
        $query = $this->db->getQuery(true);

        $query
            ->select($this->db->quoteName(array('id', 'name', 'email')))
            ->from($this->db->quoteName('d7oom_newsletter'));

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
            if ($value->is_subscribed == 1) {
                $this->showMessage('Email subscribed Already', 'error');
            } else {
                $columns = array('name', 'email', 'is_subscribed');
                $values = array($this->db->quote($name), $this->db->quote($email), $this->db->quote($is_subscribed));
                $query->clear();

                //Query for insert into DB
                $query
                    ->insert($this->db->quoteName('d7oom_newsletter'))
                    ->columns($this->db->quoteName($columns))
                    ->values(implode(',', $values));

                $this->db->setQuery($query);
                $this->db->execute();
                $this->showMessage('Subscribed successfully', 'success');
            }
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
            ->from($this->db->quoteName('d7oom_newsletter'));

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
                    // $this->db->quotename('name') . ' = ' .  $this->db->quote($value->name),
                    // $this->db->quotename('email') . ' = ' .  $this->db->quote($value->email)
                );

                //Deleting record
                if ($value->is_subscribed == 0) {
                    $this->showMessage('Email Unsubscribed Already', 'error');
                } else {
                    $query->update($this->db->quoteName('d7oom_newsletter'));
                    $query->where($conditions);
                    $query->set($this->db->quotename('is_subscribed') . ' = ' .  $this->db->quote(0),);
                    $this->db->setQuery($query);
                    $this->db->execute();
                    $this->showMessage('Unsubscribed successfully', 'success');
                }
                break;
            }
        }

        if ($flag == 0) {
            $this->showMessage("Email Address Not Found", 'error');
        }
    }
}
