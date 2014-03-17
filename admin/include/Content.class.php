<?php

class Content
{
    private $header;
    private $body;
    private $isBodyHTML;
    
    public function __construct($header, $body, $isBodyHTML)
    {
        $this->header = $header;
        $this->body = $body;
        $this->isBodyHTML = $isBodyHTML;
    } 
    
    public function getHeader() 
    {
        return $this->header;
    }
    
    public function getBody()
    {
        return $this->body;
    }
    
    public function printContent()
    {
        if ($this->header)
            echo "\t\t    <h3>$this->header</h3>\n";
        if ($this->isBodyHTML)
            echo "\t\t   $this->body";
        else 
        {
            
            $paragraphs = explode("\n", $this->body);
            foreach ($paragraphs as $paragraph)
                echo "\t\t    <p>$paragraph</p>\n";
        }

    }
}
