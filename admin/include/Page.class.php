<?php

class Page
{
    private $name;
    private $header;
    private $custom;
    private $contents; // Array of Content
    
    public function __construct($header, $contents, $custom = false)
    {
        $this->header = $header;
        $this->contents = $contents;
        $this->custom = $custom;
    }
    
    public function getHeader()
    {
        return $this->header;
    }
    
    public function getContents()
    {
        return $this->contents;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function isCustom()
    {
        return $this->custom;
    }
    
    public function printPage()
    {
        echo "\t\t    <h1>$this->header</h1>\n";
        foreach ($this->contents as $content)
            $content->printContent();
    }
    
    public static function buildPage($page_name, $db)
    {
        $query = 'SELECT id, name, pages.header as page_header, custom, page_content.position, page_content.header as page_content_header, page_content.body, page_content.isHTML ' .
                 'FROM pages INNER JOIN page_content ' . 
                 'ON page_content.page = pages.id ' .
                 'WHERE name = :name ORDER BY position ASC';
                 
        $query_params = array(':name' => $page_name);
        try
        {
            $stmt = $db->prepare($query);
            $stmt->execute($query_params);
        }
        catch (PDOException $e)
        {
            die();
        }
        $rows = $stmt->fetchAll();
        
        if (!$rows)
        {
            return null;
        }
        else 
        {
            include_once($_SERVER['DOCUMENT_ROOT'] . "/admin/include/Content.class.php");
            
            $contents = array();
            foreach ($rows as $row)
                $contents[] = new Content($row['page_content_header'], $row['body'], $row['isHTML'] == 0 ? false : true);
                
            return new Page($rows[0]['page_header'], $contents, ($rows[0]['custom'] == 1));   
        }
        
    }
}
