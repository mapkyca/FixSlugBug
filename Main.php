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
	
	public static function check1741and1864() {
	    $idswithduplicateuuids = [];
	    
	    self::writeln("\n\n** Checking for interaction between #1741 and #1864 **");
	    
	    $limit = 50;
	    $offset = 0;
	    
	    while ($items = \Idno\Common\Entity::getFromX(null, [], array(), $limit, $offset)) {
		foreach ($items as $item) {
		    
		    //self::writeln("* Looking at " . $item->getUUID() . ' (' . get_class($item) . ') : ' . $item->getTitle());
		    
		    // Pull entity by slug
		    $uuids = \Idno\Common\Entity::getFromX(null, ['uuid' => $item->getUUID()], array());
		    if (($count = count($uuids)) > 1) {
		
			self::writeln("\tUUID/Slugbug interaction found in $count objects"); 
			
			foreach ($uuids as $u) {
			    $id = $u->getID();
			    $idswithduplicateuuids["$id"] = $u->getUUID();
			}
		    }
		    
		    $item = null;
		}
		
		$items = null;
		gc_collect_cycles();
		
		$offset += $limit;
	    }
	    
	    
	    if (empty($idswithduplicateuuids)) {
		self::writeln("No duplicate UUIDs/URLs found, all Ok");
	    } else {
		self::writeln("Oh dear, the following entity IDs have duplicate UUIDs/URLs...");
		
		foreach ($idswithduplicateuuids as $id => $url) {
		    self::writeln("\tID:$id => $url");
		}
	    }
	}
	
	public static function fix1864($dryrun = false) {
	    
	    if ($dryrun) self::writeln ("**************** DRY RUN *****************");
	    
	    if (\Idno\Core\Idno::site()->getMachineVersion()< 2017082201)
		die("Please run on the latest version of Known");
	    
	    self::writeln("Execution started at " . date('r'));
	    self::writeln();
	    
	    $limit = 50;
	    $offset = 0;
	    
	    $handled = [];
	    
	    while ($items = \Idno\Common\Entity::getFromX(null, [], array(), $limit, $offset)) {
		
		foreach ($items as $item) {
		    
		    self::writeln("* Looking at " . $item->getUUID() . ' (' . get_class($item) . ') : ' . $item->getTitle());
		    
		    // Pull entity by slug
		    $slugged = \Idno\Common\Entity::getFromX(null, ['slug' => $item->slug], array());
		    if (($count = count($slugged)) > 1) {
		
			self::writeln("\tSlugBug Found in $count objects"); 
			
		    	// Handle array in reverse order, skipping the LAST value, since we want this to retain the original slug
			$cnt = 1;
			for ($n=$count-1; $n >= 0; $n--) {
			    
			    $newslug = "";
			    $tmp = $slugged[$n];
			    
			    if (!in_array($tmp->getUUID(), $handled)) {
				if ($n == $count-1) {

				    self::writeln("\t\t" . $tmp->getUUID() . ", created " . date('r', $tmp->created) . ", is the oldest entity, leaving it's slug as " . $tmp->slug);
				} else {

				    // Save, in case we need to revert
				    $tmp->fix_1864_orig_slug = $tmp->slug;

				    // Recalculate slug
				    if (!($title = $tmp->getTitle())) {
					if (!($title = $tmp->getDescription())) {
					    $title = md5(mt_rand() . microtime(true));
					}
				    }
				    //\Idno\Core\Idno::site()->logging()->debug("Setting resilient slug");

				    $newslug = $tmp->slug . '-'. ($cnt++); // Fudge the slug a little, since setResiliantSlug seems to not work a second time
				    while ($e = \Idno\Common\Entity::getBySlug($newslug)) {
					$newslug = $tmp->slug . '-'. ($cnt++); 
				    }
				    
				    $tmp->slug = $newslug;

				    self::writeln("\t\t" . $tmp->getUUID() . ", created " . date('r', $tmp->created) . ", will be renamed to $newslug");
				    
				    if (!$dryrun)
					$tmp->save();

				}

				$handled[] = $tmp->getUUID();
			    } else {
				self::writeln("\t\tHmm... already handled ".$tmp->getUUID().", this is probably a dry run anyway...");
			    }
			}
			
		    }
		    
		    
		    
		    
		    
		    $item = null;
		}
		
		$items = null;
		gc_collect_cycles();
		
		$offset += $limit;
	    }
	    
	    
	    self::check1741and1864();
	    
	    
	    self::writeln("Execution finished at " . date('r'));
	    
	    if ($dryrun) self::writeln ("**************** DRY RUN *****************");
	}
	
    }
