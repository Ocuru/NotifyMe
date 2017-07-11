<?php
namespace Ocuru\Notify\Contracts;

interface RuleContract
{
    /**
     * The error given if the rule fails.
     *
     * @return string
     */
    public function error();

    /**
     * Returns the error message
     */
    public function getMessage();

    /**
     * If the rule can be skipped, becuase it isn't required
     *
     * @return [type] [description]
     */
    public function canSkip();
}