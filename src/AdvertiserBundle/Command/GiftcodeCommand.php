<?php
namespace AdvertiserBundle\Command;
use Propel\Runtime\ActiveQuery\Criteria;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Hotspot\AccessPointBundle\Model\UserDataCollectionQuery;
use Common\DbBundle\Model\Giftcode;
use Common\DbBundle\Model\GiftcodeQuery;

class GiftcodeCommand extends ContainerAwareCommand
{
    private $type = 1000; // Code có giá trị 1K
    private $link_chplay = 'https://play.google.com/store/apps/details?id=game.ibig.android';
    private $link_store = 'https://itunes.apple.com/us/app/ibig-danh-bai-online/id1185828247?l=vi&ls=1&mt=8&v=1';

    protected function configure()
    {
        $this
            ->setName('app:scan_ibig_gift_code')
            ->setDescription('Cron email user_data_collection')
            ->addArgument(
                'advert',
                InputArgument::OPTIONAL,
                'Advert ID'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $advert = $input->getArgument('advert') ? $input->getArgument('advert') : '';
        //if($advert != ''){
        //    $conditions = array('status' => 0, 'advertId' => $advert);
        //}else{
        //    $conditions = array('status' => 0);
        //}
        $list = UserDataCollectionQuery::create()->limit(10)
            ->filterByStatus(0)
            ->filterByAdvertId(array(130,131,132,133,134,135),Criteria::IN)
            ->find();

        if(count($list) > 0){
            /** @var \Swift_Transport $transport */
            //$transport = $this->getContainer()->get('swiftmailer.transport.real');
            //$api_service = \Swift_Mailer::newInstance($transport);
            $api_service = $this->getContainer()->get("mailer");

            foreach ($list as $key => $value){

                $one = GiftcodeQuery::create()->select(array('id'))->filterByEmail($value->getData())->filterByAdvertId($value->getAdvertId())->findOne();
                if(count($one) == 0){

                    $giftcode = GiftcodeQuery::create()->filterByStatus(0)->filterByType($this->type)->findOne();
                    if($giftcode){
                        $code = $giftcode->getValue();
                        $giftcode->setEmail($value->getData());
                        $giftcode->setAdvertId($value->getAdvertId());
                    }else{
                        $code = 'Code tạm thời đã hết, bạn quay lại sau nhé!';
                    }

                    if($giftcode->save()){

                        $tem = $this->renderTemplate($code);

                        $message = \Swift_Message::newInstance('IBIG')
                            ->setFrom(array('hotro.ibig@gmail.com' => 'iBIG - Game bài online'))
                            ->setTo(array($value->getData()))
                            ->setBody($tem, 'text/html');

                        $result = $api_service->send($message);
                        if($result) {
                            $giftcode->setStatus(1); // Gửi đến mail thành công
                        }else{
                            $giftcode->setStatus(-1); // Gửi đến mail thất bại
                        }
                        $giftcode->save();
                    }
                }
                $value->setStatus(1);
                $value->save();
            }
        }

        $output->writeln("DONE!");
    }

    private function renderTemplate($code)
    {
        return $this->getContainer()->get('templating')->render(
            'AdvertiserBundle:Giftcode:mail.html.twig',
            array(
                'code'  =>  $code,
                'link_ch'  => $this->link_chplay,
                'link_store' => $this->link_store
            )
        );
    }
}