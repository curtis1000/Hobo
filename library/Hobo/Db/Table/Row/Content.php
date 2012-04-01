<?php

class Hobo_Db_Table_Row_Content extends Hobo_Db_Table_Row
{
    public function getId()
    {
        return $this->id;
    }
    
    public function getRouteName()
    {
        return $this->routeName;
    }
    
    public function setRouteName($value)
    {
        $this->routeName = $value;
        return $this;
    }
    
    public function getHandle()
    {
        return $this->handle;
    }
    
    public function setHandle($value)
    {
        $this->handle = $value;
        return $this;
    }
    
    public function getIsGlobal()
    {
        return $this->isGlobal;
    }
    
    public function setIsGlobal($value)
    {
        $this->isGlobal = $value;
        return $this;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function setContent($value)
    {
        $this->content = $value;
        return $this;
    }
    
    public function getRevision()
    {
        return $this->revision;
    }
    
    public function setRevision($value)
    {
        $this->revision = $value;
        return $this;
    }
}