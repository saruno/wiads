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
class UserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "app/console")
            ->setName('app:update_ads_report')

            // the short description shown while running "php app/console list"
            ->setDescription('Update Ads Report.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you to update ads report.")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $api_service = $this->getContainer()->get("accesspoint.service");
        if($api_service!=null) {
            $y = date("Y");
            $m = date("m");
            $d = date("d");
            //$api_service->updateAdsReport($y,$m);
            $api_service->updateAdsReportDay($y,$m,$d);
        }
        $output->writeln('Ads report successfully updated!');
    }
}