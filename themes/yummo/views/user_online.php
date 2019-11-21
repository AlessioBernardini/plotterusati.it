<?php

/*
 * Author : Reza Ramezanpour <<a href="mailto:reza.irdev@gmail.com" rel="nofollow">reza.irdev@gmail.com</a>>
 * Website: <a href="http://softafzar.net
" rel="nofollow">http://softafzar.net
</a> */

class SA_USERSONLINE
{

    protected $DB_HOST = "localhost";

    protected $DB_NAME = "plott219_open540";

    protected $DB_USER = "plott219_open540";

    protected $DB_PWD = "33nApS7(u.";

    protected $session_id = null;

    protected $time = null;

    protected $timeout = 15;

    protected $link = null;

    protected $stmt = null;

    function __construct ()
    {
        //session_start();
        $this->session_id = session_id();
        $this->time = time();
        $this->link = mysqli_connect($this->DB_HOST, $this->DB_USER,
            $this->DB_PWD, $this->DB_NAME);
    }

    /**
     * Gets current online users
     */
    function get_online_users ()
    {
        $this->delete_update_onlineusers();
        $this->insert_onlineusers();
        $this->stmt = mysqli_query($this->link,
            'SELECT session_id FROM online_users');
        return mysqli_num_rows($this->stmt);
    }

    private function already_registred ()
    {
        $this->stmt = mysqli_query($this->link,
            "SELECT session_id FROM online_users WHERE session_id='$this->session_id'");
        if (! $this->stmt || mysqli_num_rows($this->stmt) <= 0)
            return false;
        return true;
    }

    private function insert_onlineusers ()
    {
        if (! $this->already_registred()) {
            mysqli_query($this->link,
                "INSERT INTO online_users VALUES('$this->session_id',$this->time)");
        }
    }

    private function delete_update_onlineusers ()
    {
        $timeout = $this->time - ($this->timeout * 60);
        mysqli_query($this->link,
            "DELETE FROM online_users WHERE last_activity<=$timeout");
        mysqli_query($this->link,
            "UPDATE online_users SET last_activity=$this->time WHERE session_id='$this->session_id'");
    }

    /**
     * Set timeout in minutes.
     *
     * @param int $timeout
     */
    function set_timeout ($timeout)
    {
        $this->timeout = ((int) $timeout);
    }
}

$usersOnline = new SA_USERSONLINE();
$html = "<p id='online_user'> Utenti on-line: ";
$html .= "<b>";
$html .= $usersOnline->get_online_users();
$html .= "</b>";
$html .= "</p>";
echo $html;