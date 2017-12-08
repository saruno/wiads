<?php
// src/ApiBundle/Helper/DefinedHelper.php
namespace ApiBundle\Helper;

class DefinedHelper
{
	static public function getTemplatesLogin()
	{
		return array(
			'captival_full_screen_v4.html.twig'		=>	'Tự động login - Quảng cáo chung - 640x710',
			'captival_fblogin_v1.html.twig'			=>	'Login bằng Facebook',
			'captival_fb_share_login.html.twig'		=>	'Share Facebook để dùng Internet',
			'captival_vlp.html.twig'				=>	'Value point Ads',
			'mac.html.twig'							=>	'Giải pháp riêng theo MAC - Quảng cáo chung - 640x710'
		);
	}

	static public function getMode()
	{
		return array(
			'option normal_mode 0' => 'Chế độ hiển thị LOGIN (QC)', 
			'option normal_mode 1' => 'Chế độ thường'
		);
	}

	static public function getBwProfileList()
	{
		return \Hotspot\AccessPointBundle\Model\Base\BwProfileQuery::create()->find();
	}
}