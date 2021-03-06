<?php
namespace Bolt\Extensions\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\ArrayInput;

use Doctrine\ORM\EntityManager;
use Bolt\Extensions\Entity;


use Composer\Satis\Command\BuildCommand;



class Builder extends Command {
    
    
    public $period = 1800;
    public $em;
    
 
    public function __construct(EntityManager $em = null) {
        if(false !== $em) $this->em = $em;
        parent::__construct();
    }


    protected function configure() {
        $this->setName("bolt:builder")
                ->setDescription("Always running command to trigger build of repo every 30 minutes.");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        
        // capture error output
        $stderr = $output instanceof ConsoleOutputInterface
            ? $output->getErrorOutput()
            : $output;
        
        $error = '';
        while (true) {
            try {
                
                $command = new Satis($this->em);
                $input = new ArrayInput([]);
                $returnCode = $command->run($input, $output);
                if($returnCode === 0) {
                    $output->writeln("<info>Satis file built...</info>");
                    
                    
                    $command = 'vendor/bin/satis build';
                    $output->writeln(shell_exec($command));
                    
                    $command2 = 'console bolt:update';
                    $output->writeln(shell_exec($command2));

                }
                
            } catch (\Exception $e) {

                    
                if ($error != $msg = $e->getMessage()) {
                    $stderr->writeln('<error>[error]</error> '.$msg);
                    $error = $msg;
                }
            }

            $wait = $this->period / 60;
            $output->writeln("<comment>Sleeping for $wait minutes</comment>");
            sleep($this->period);
        }

    }
    


}