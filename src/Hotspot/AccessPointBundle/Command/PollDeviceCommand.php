<?php
/**
 * User: nhnhat
 * Date: 10/23/16
 * Time: 5:02 PM
 */

namespace Hotspot\AccessPointBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;
class PollDeviceCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "app/console")
            ->setName('app:poll_device')

            // the short description shown while running "php app/console list"
            ->setDescription('Polling device.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command poll devices status.")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $api_service = $this->getContainer()->get("accesspoint.service");
        if($api_service!=null) {
            $y = date("Y");
            $m = date("m");
            $d = date("d");
            $api_service->pollDevice();
        }
        //$dateA=date("Y-m-d h:i:s",strtotime("-10 minutes"));
	    //$dateB=date("Y-m-d h:i:s",strtotime("-6 hours"));
        //$output->writeln($dateA.",".$dateB);
        $output->writeln('Polling successfully!');
    }
}