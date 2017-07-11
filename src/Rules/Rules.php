<?php
namespace Ocuru\Notify\Rules;

class Rules
{
	protected static function getRuleToCall($rule)
	{
		$ruleClass = 'Ocuru\\Notify\\Rules\\'.$rule.'Rule';
        $ruleObject = new $ruleClass();
        return $ruleObject;
	}

	public static function getRuleError($rule)
	{
		$rule = Rules::getRuleToCall($rule);
		if(!$rule->canSkip()){
			return $rule->error();
		}		
	}

	public static function verify($rules)
	{
		
	}
}