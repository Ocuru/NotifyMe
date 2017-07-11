<?php
namespace Ocuru\Notify\Rules;

use Ocuru\Notify\Contracts\RuleContract;

class SubjectRule implements RuleContract
{
	public function error()
	{
		// throw new \Exception($this->getMessage());
		return $this->getMessage();
	}

	public function getMessage()
	{
		return "The Subject field is required.";
	}

	public function canSkip()
	{
		return false;
	}
}