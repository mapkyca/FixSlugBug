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
	    set_time_limit(0);
	    
	    $dryrun = $this->getInput('dryrun');
	    if (!empty($dryrun)) $dryrun = true;
	    
	    echo "<pre>";
	    \IdnoPlugins\FixSlugBug\Main::fix1864($dryrun);
	    echo "</pre>";
	    
	    
	    exit;
        }


    }
