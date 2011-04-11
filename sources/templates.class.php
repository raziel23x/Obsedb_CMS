<?php

class Template 
{
    
    var $vars;
    var $data;
    var $template;
    
    function open_template( $title )
    {
        global $db;
        $result = $db->Execute("SELECT * FROM `Obsedb_templates` WHERE `title` = '$title';");
        $result->fields['html'] = stripslashes($result->fields['html']);
        $this->template = $result->fields['html'];
    }
    
    function parse_template()
    {
        $this->parsed_template = str_replace( $this->vars, $this->data, $this->template );
        unset($this->vars);
        unset($this->data);
    }
    
    function addvar( $name, $value )
    {
        $this->vars[] = $name;
        $this->data[] = $value;
    }
    
    function print_template()
    {
        if (isset($this->parsed_template))
        {
            print $this->parsed_template;
        } else {
            print $this->template;
        }
    }
}