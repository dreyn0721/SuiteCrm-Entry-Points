<?php

class AsteriskIntegration extends Basic
{
    public $new_schema = true;
    public $module_dir = 'AsteriskIntegration';
    public $object_name = 'AsteriskIntegration';
    public $table_name = 'asteriskintegration';
    public $importable = false;

    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $description;
    public $deleted;
    public $created_by_link;
    public $modified_user_link;
    public $assigned_user_id;
    public $assigned_user_name;
    public $assigned_user_link;
    public $SecurityGroups;
    public $add_desscription;
    public $direction;
    public $status;
    public $call_date;
    public $call_time;
    public $asterisk_server;
    public $disposition;
    public $extension;
    public $number;
    public $duration_hours;
    public $duration_minutes;
    public $duration_seconds;
    public $duration;

    public function bean_implements($interface)
    {
        switch ($interface)
        {
            case 'ACL':
                return true;
        }

        return false;
    }

}
