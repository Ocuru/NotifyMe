<?php
namespace Ocuru\Notify\Rules;

use Ocuru\Notify\Contracts\RuleContract;

class FromNameRule implements RuleContract
{
	public function error()
	{
		// throw new \Exception($this->getMessage());
		return $this->getMessage();
	}

	public function getMessage()
	{
		return "The FromName field is required.";
	}

	public function canSkip()
	{
		return false;
	}
}