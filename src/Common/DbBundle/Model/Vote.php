<?php

namespace Common\DbBundle\Model;

use Common\DbBundle\Model\Base\Vote as BaseVote;

/**
 * Skeleton subclass for representing a row from the 'vote' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Vote extends BaseVote
{
	public function getQuestions(){
		return VoteQuestionQuery::create()
		->orderById()
		->joinWithI18n(self::getLocale())
		->findByVoteId(self::getId());
	}
}
