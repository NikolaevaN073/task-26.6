<?php

class MetatagsIterator implements Iterator
{        
    protected $metatags = [];
    
    public function current()
    {
      return current($this -> metatags);
    }

    public function key()
    {
      return key($this -> metatags);
    }

    public function next()
    {
      next($this -> metatags);
    }

    public function rewind()
    {
      reset($this -> metatags);
    }

    public function valid()
    {
      return current($this -> metatags) !== false;
    }

    public function set (string $metatag)
    {         
        $this -> metatags[] = $metatag;
        return $this;
    }

}

class FilesIterator implements Iterator
{
    protected $content = [];
    
    public function current()
    {
      return current($this -> content);
    }

    public function key()
    {
      return key($this -> content);
    }

    public function next()
    {
      next($this -> content);
    }

    public function rewind()
    {
      reset($this -> content);
    }

    public function valid()
    {
      return current($this -> content) !== false;
    }

    public function getContent ($filename) 
    {
        return $this -> content = file($filename);          
    } 

    public function putContent ($filename, $content) 
    {
        return $this -> content = file_put_contents($filename, $content);          
    } 

}

$meta = new MetatagsIterator();
$meta -> set ("<title>");
$meta -> set ('description');
$meta -> set ('keywords');

$fileContent = new FilesIterator();

$new_content = [];

foreach ($fileContent -> getContent('view.php') as $line_num => $line) {
    $meta_in_string = 0;
    foreach ($meta as $value) {
        if (strpos($line, $value)) {
            $meta_in_string = 1;           
        } 
    }
    if ($meta_in_string !== 0) {
        continue;
    } else {
        $new_content[] = $line;
    }             
}

$fileContent -> putContent('new_view.php', $new_content); 
