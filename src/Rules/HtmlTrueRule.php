<?php
namespace Ocuru\Notify\Rules;

use Ocuru\Notify\Contracts\RuleContract;

class HtmlTrueRule implements RuleContract
{
	public function error()
	{
		// throw new \Exception($this->getMessage());
		return $this->getMessage();
	}

	public function getMessage()
	{
		return "If <b>isHTML</b> is set to true, then <b>MessageHTML</b> needs to be set.";
	}

	public function canSkip()
	{
		return false;
	}
}