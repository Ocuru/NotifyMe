<?php
namespace Ocuru\Notify\Rules;

use Ocuru\Notify\Contracts\RuleContract;

class FromEmailRule implements RuleContract
{
	public function error()
	{
		// throw new \Exception($this->getMessage());
		return $this->getMessage();
	}

	public function getMessage()
	{
		return "The FromEmail field is required.";
	}

	public function canSkip()
	{
		return false;
	}
}