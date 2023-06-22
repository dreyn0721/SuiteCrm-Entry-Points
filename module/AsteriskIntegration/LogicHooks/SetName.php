<?php

class SetNameClass
{
    public function SetNameFunction($bean, $event, $arguments)
    {
        if (empty($bean->fetched_row))
        {
            if ($bean->direction == "Outbound")
            {
                $bean->name = $bean->direction . " Call From : " . $bean->extension . " To : " . $bean->number;
            }
            elseif ($bean->direction == "Inbound")
            {
                $bean->name = $bean->direction . " Call From : " . $bean->number . " To : " . $bean->extension;
            }
            else
            {
                $bean->name = "Unknown Call";
            }
        }
    }
}
