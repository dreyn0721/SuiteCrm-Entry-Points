<?php

class AddDescriptionClass
{
    public function AddDescriptionFunction($bean, $event, $arguments)
    {
        if (!empty(trim($bean->add_description)))
        {
            global $current_user;

            $add_description = "Date : " . date('d-m-Y H:i') . " (" . $current_user->user_name . ")\n";
            $add_description .= "Comments : " . trim($bean->add_description) . "\n";
            $add_description .= "----------------------------------\n";

            $bean->description = $add_description . $bean->description;
            $bean->add_description = "";
        }
    }
}
