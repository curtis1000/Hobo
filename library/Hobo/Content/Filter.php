<?php
/**
 * input is the body of the page, we need to parse the dom for any
 * elements that have a class starting with "editable-" and then derive
 * the handle from it (editable-<handle>). For each instance of an
 * editable element, we will attempt to replace its content with any
 * matching content in the database
 */
class Hobo_Content_Filter
{
    protected $_input = '';
    protected static $EditableClassPrefix = 'editable-';
    protected static $XpathQueryAnyElementWithAClass = '//*[@class]';
    
    public function setInput($value)
    {
        $this->_input = $value;
        return $this;
    }

    public function filter()
    {
        $domDoc = new DOMDocument();
        @$domDoc->loadHTML($this->_input);
        $editableElements = $this->findEditableElements($domDoc);
        
        foreach ($editableElements as $element) {
            
            // query database for content
            $content = 'query results placeholder';
            
            if (! empty($content)) {
                // remove any children
               while ($element->hasChildNodes()){
                   $element->removeChild($element->childNodes->item(0));
               }              
               // inject content
               $fragment = $domDoc->createDocumentFragment(); // create fragment
               $fragment->appendXML($content); 
               $element->appendChild($fragment);               
            }
        }
        return $domDoc->saveHTML();
    }
    
    protected function findEditableElements($domDoc)
    {
        $domXpath = new DOMXPath($domDoc);
        $editableElements = array();
        
        // query any elements that have a class attribute
        $elements = $domXpath->query(self::$XpathQueryAnyElementWithAClass);
    
        if ($elements instanceof DOMNodeList) {
            foreach ($elements as $element) {
                // element is a DOMElement
                $classAttr = $element->getAttribute('class');
                $classes = explode(' ', $classAttr);

                foreach ($classes as $class) {
                    if (substr($class, 0, strlen(self::$EditableClassPrefix))
                        == self::$EditableClassPrefix) {
                        $editableElements[] = $element;
                    }
                }
            }
        }
        
        return $editableElements;
    }
}