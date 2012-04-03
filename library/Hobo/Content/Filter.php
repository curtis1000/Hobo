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
    protected static $EditableDataPrefix = 'data-';
    protected static $XpathQueryAnyElementWithADataAttr = "//*[@*[starts-with(name(.), 'data-')]]";
    
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
        
        foreach ($editableElements as $elementArray) {
            $element = $elementArray['element'];
                
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
    
    /**
     * Finds Editable Elements
     * 
     * @param  object $domDoc
     * @return array  $editableElements
     */
    protected function findEditableElements($domDoc)
    {
        $domXpath = new DOMXPath($domDoc);
        $editableElements = array();
        
        /**
         * Queries Any Element With The HTML5 Data Attribute
         */
        $elements = $domXpath->query(self::$XpathQueryAnyElementWithADataAttr);
    
        if ($elements instanceof DOMNodeList) {

            /**
             * Loops Through The ELements
             */
            foreach ($elements as $element) {

                /**
                 * Checks If The Element Has Attributes
                 */
                if ($element->hasAttributes()) {
                    $options = array();

                    /**
                     * Loops Through All of The Elements Attributes
                     */
                    foreach ($element->attributes as $attr) {

                        /**
                         * Gets The Attributes That Contain The Prefix
                         */
                        if (substr($attr->nodeName, 0, strlen(self::$EditableDataPrefix)) == self::$EditableDataPrefix) {
                            $options[$attr->nodeName] = $attr->nodeValue;
                        }
                    }

                    /**
                     * Creates The Data Array
                     */
                    $editableElements[] = array(
                        'element' => $element,
                        'options' => $options,
                    );
                }
            }
        }

        return $editableElements;
    }
}