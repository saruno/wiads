<?php

namespace AdvertiserBundle\Helper;


class SyntheticHelper
{

	/**
	 *	Hàm lấy số ngày của một tháng (Ví dụ: tháng 12 có 31 ngày)
	 *	@param $month
	 *	@return số ngày của tháng
	 */
	public static function getNumberDayOnMonth($month){
		switch ($month) {
			case 1:
				return 31;
			case 2:
				return SyntheticHelper::checkLeapYear()  ? 29 : 28;
			case 3:
				return 31;
			case 4:
				return 30;
			case 5:
				return 31;
			case 6:
				return 30;
			case 7:
				return 31;
			case 8:
				return 31;
			case 9:
				return 30;
			case 10:
				return 31;
			case 11:
				return 30;
			case 12:
				return 31;
			default:
				return 31;
		}
	}

	/**
	 * Hàm kiểm tra năm nhuận
	 * @param $date ; nếu có sẽ kiểm tra năm truyền vào, ko có thì lấy năm hiện tại
	 */
	public static function checkLeapYear($date = null){
		$d = $date == null ? date("Y-m-d") : $date;
		if(date('L', strtotime($d)))
			return true;
		else return false;
	}
}