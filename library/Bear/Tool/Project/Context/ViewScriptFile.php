<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Tool
 */

/**
 * View Script File Context
 *
 * @category Bear
 * @package Bear_Tool
 * @author Konr Ness <konr.ness@sierra-bravo.com>
 * @version $Id$
 */
class Bear_Tool_Project_Context_ViewScriptFile
    extends Zend_Tool_Project_Context_Zf_ViewScriptFile
{

    /**
     * Action context (json, html, ajax, etc.)
     *
     * @var string
     */
    protected $_actionContext;
    
    /**
     * Add support to parent init() for action contexts in view script filename
     *
     * @return Bear_Tool_Project_Context_ViewScriptFile
     */
    public function init()
    {
        parent::init();
        
        if ($actionContext = $this->_resource->getAttribute('actionContext')) {
            $this->_actionContext = $actionContext;
            
            // insert action context into file system name
            $this->_filesystemName = 
                substr($this->_filesystemName, 0, -6) 
                . '.' . $this->_actionContext 
                . substr($this->_filesystemName, -6);
        }
        
        return $this;
    }
    
    /**
     * Add support for additional file contents for error controller actions
     *
     * @return string
     */
    public function getContents()
    {
        $contents = '';
        
        // handle content for error controller actions
        if ($this->_resource->getParentResource()->getAttribute('forControllerName') == 'Error') {
            switch ($this->_filesystemName) {
                case 'authentication-required.ajax.phtml':
                    $contents = $this->_getAuthenticationRequiredContents();
                    break;
                case 'forbidden.phtml':
                    $contents = $this->_generateErrorContents(
                        'Forbidden',
                        'You do not have permission to access this page'
                    );
                    break;
                case 'internal-server-error.phtml':
                    $contents = $this->_generateErrorContents(
                        'Error',
                        'An error occurred'
                    );
                    break;
                case 'not-found.phtml':
                    $contents = $this->_generateErrorContents(
                        'Page Not Found',
                        'The requested page could not be found'
                    );
                    break;
                default:
                    $contents = parent::getContents();
            }
        } elseif ($this->_forActionName == 'index' && $this->_resource->getParentResource()->getAttribute('forControllerName') == 'Index') {
            $contents = $this->_generateIndexIndexContents();
        } else {
            $contents = parent::getContents();
        }
        return $contents;
    }
    
    /**
     * Contents for authentication-required view script
     *
     * @return string
     */
    protected function _getAuthenticationRequiredContents()
    {
        if ($this->_actionContext != 'ajax') {
            throw new Exception('Unknown content for non-ajax action required view script');
        }
        
        return <<<EOS
<script type="text/javascript">
top.location.href = "<?php echo \$this->url(array('module' => 'users', 'controller'=>'account', 'action' => 'login'), 'default', true); ?>";
</script>
EOS;
    }
        
    /**
     * Contents for error view script
     *
     * @param string $title
     * @param string $message
     * @return string
     */
    protected function _generateErrorContents($title, $message) {
        return <<<EOS
<?php \$this->headTitle("$title"); ?>
<h1>$message</h1>

<?php if (\$this->showExceptions): ?>

<h2><?php echo \$this->exception->getMessage(); ?></h2>

<h3>Exception information:</h3>
<p>
  <b>Message:</b> <?php echo \$this->exception->getMessage() ?>
</p>

<h3>Stack trace:</h3>
<pre><?php echo \$this->exception->getTraceAsString() ?>
</pre>

<h3>Request Parameters:</h3>
<pre><?php echo var_export(\$this->request->getParams(), true) ?>
</pre>
<?php endif ?>

EOS;
        
    }
    
    /**
     * Contents for index/index view script
     *
     * @return string
     */
    protected function _generateIndexIndexContents()
    {
        return <<<EOS
<style>
    a:link,
    a:visited
    {
        color: white;
    }

    span#nerdery-name
    {
        color: #AEC0AF;
        text-shadow: white 1px 1px;
    }

    span#zf-name
    {
        color: #91BE3F;
    }

    div#welcome
    {
        color: #FFFFFF;
        background-image: url(http://www.nerdery.com/images/bg_bodynew.jpg);
        width:  600px;
        height: 350px;
        border: 2px solid #444444;
        overflow: hidden;
        text-align: center;
        font-family: Helvetica,Arial,sans-serif
    }

    div#more-information
    {
        height: 100%;
    }

    h1
    {
        color: black;
        text-shadow: #D3D9D8 1px 1px;
    }

</style>
<div id="welcome">
    <h1>Welcome to<br/> <span id="nerdery-name">Nerdery</span> <span id="zf-name">Zend Framework!</span></h1>

    <h3>This is your project's main page</h3>

    <div id="more-information">
        <p><img src="http://framework.zend.com/images/PoweredBy_ZF_4LightBG.png" /></p>
        <p><img src="http://codecat.sierrabravo.net/img/logo_nerdery.png" width="130" /></p>
        <p>
            Helpful Links: <br />
            <a href="http://framework.zend.com/">Zend Framework Website</a> |
            <a href="http://framework.zend.com/manual/en/">Zend Framework Manual</a> |
            <a href="https://trac.sierrabravo.net/BEAR/">Bear Trac</a>
        </p>
    </div>
</div>        
EOS;
    }
}
