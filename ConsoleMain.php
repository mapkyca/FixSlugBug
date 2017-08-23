<?php

namespace IdnoPlugins\FixSlugBug {

    class ConsoleMain extends \Idno\Common\ConsolePlugin {

	public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output) {
	    
	    $dryrun = $input->getArgument('dryrun');
	    if (!empty($dryrun))
		$dryrun = true;
	    
	    \Idno\Core\Idno::site()->db()->setIgnoreAccess(true);
	    
	    \IdnoPlugins\FixSlugBug\Main::fix1864($dryrun);
	    
	    \Idno\Core\Idno::site()->db()->setIgnoreAccess(false);
	}

	public function getCommand() {
	    return 'fix-slugbug';
	}

	public function getDescription() {
	    return "Fix the slug error fixed by #1864";
	}

	public function getParameters() {
	    return [
		new \Symfony\Component\Console\Input\InputArgument('dryrun', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Simulate result so you can review the result', false),
	    ];
	}

    }

}