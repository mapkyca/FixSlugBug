<?php

    namespace IdnoPlugins\FixSlugBug\Pages;


    class Admin extends \Idno\Common\Page
    {
	function getContent() {
	    $this->adminGatekeeper(); // Admins only

            $t           = \Idno\Core\Idno::site()->template();
            $body = $t->__([])->draw('admin/slugbug');
            $t->__(['title' => 'Fix #1864', 'body' => $body])->drawPage();
	}
	
	private function writeln($txt) {
	    echo $txt . "\n";
	}
	
        function postContent()
        {
            $this->adminGatekeeper();
	    
	    $dryrun = $this->getInput('dryrun', false);
	    if (!empty($dryrun)) $dryrun = true;
	    
	    ob_start();
	    \IdnoPlugins\FixSlugBug\Main::fix1864($dryrun);
	    $out = ob_get_clean();
	    
	    echo "<pre>$out</pre>";
	    
	    exit;
        }


    }
