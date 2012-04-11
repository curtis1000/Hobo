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
    /**
     * Response Body
     */
    protected $_input = '';

    /**
     * XPath Query
     */
    protected static $XpathQuery = '//*[@data-hobo]';

    /**
     * Query Attribute
     */
    protected static $attrQuery = 'data-hobo';
    
    /**
     * Gets The Response Body From The DispatchLoopShutdown()
     * 
     * @param  string $value
     * @return object $this
     */
    public function setInput($value)
    {
        $this->_input = $value;
        return $this;
    }

    /**
     * Filters The Response Body
     * 
     * @return string
     */
    public function filter()
    {
        $domDoc = new DOMDocument();
        @$domDoc->loadHTML($this->_input);
        $editableElements = $this->findEditableElements($domDoc);
        
        foreach ($editableElements as $value) {
            $element = $value['element'];
            $data = $value['data'];

            // query database for content
            $contentTable = new Hobo_Db_Table_Content();
            $data['routeName'] = Zend_Controller_Front::getInstance()->getRouter()->getCurrentRouteName();
            $row = $contentTable->selectLatest($data);
            
            if (! empty($row->content)) {
                // remove any children
               while ($element->hasChildNodes()){
                   $element->removeChild($element->childNodes->item(0));
               }              
               // inject content
               $fragment = $domDoc->createDocumentFragment(); // create fragment
               $fragment->appendXML($row->content);
               $element->appendChild($fragment);               
            }
        }

        return $domDoc->saveHTML();
    }
    
    /**
     * Finds All Editable Elements
     * 
     * @param  object $domDoc
     * @return array $editableElements
     */
    protected function findEditableElements($domDoc)
    {
        $editableElements = array();
        $domXpath = new DOMXPath($domDoc);
        
        /**
         * Finds All of The Editable Elements
         */
        $elements = $domXpath->query(self::$XpathQuery);
        
        if ($elements instanceof DOMNodeList) {
            foreach ($elements as $element) {
                /**
                 * Gets Attributes Values
                 */
                $dataAttr = $element->getAttribute(self::$attrQuery);

                $editableElements[] = array(
                    'element' => $element,
                    'data'    => (array) json_decode($dataAttr),
                );
            }
        }
        
        return $editableElements;
    }
}