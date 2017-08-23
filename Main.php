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
	
	public static function writeln($text = '') {
	    echo "$text\n";
	}
	
	public static function fix1864($dryrun = false) {
	    
	    if ($dryrun) self::writeln ("**************** DRY RUN *****************");
	    
	    self::writeln("Execution started at " . date('r'));
	    self::writeln();
	    
	    
	    
	    
	    
	    
	    self::writeln("Execution finished at " . date('r'));
	    
	    if ($dryrun) self::writeln ("**************** DRY RUN *****************");
	}
	
    }
