<?php

    namespace IdnoPlugins\FixSlugBug;

    class Main extends \Idno\Common\Plugin
    {

        function registerEventHooks()
        {	    

        }

        function registerPages()
        {
	    \Idno\Core\Idno::site()->addPageHandler('/admin/slugbug/?', 'IdnoPlugins\FixSlugBug\Pages\Admin');
        }
	
	public static function fix1864($dryrun = false) {
	    
	}
	
    }
