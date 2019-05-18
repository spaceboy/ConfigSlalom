<?php

namespace Spaceboy\ConfigSlalom;

class ConfigSegment
{
    /** @var array list of conditions */
    public  $condition      = array();

    /** @var array list of actions */
    public  $action         = array();

    /** @var bool flag is to continue */
    public  $continue       = FALSE;

    /** @var bool flag is to skip */
    public  $skip           = FALSE;

    /** @var bool flag is Otherwise */
    public  $isOtherwise    = FALSE;

    /** @var bool flag is Finally */
    public  $isFinally      = FALSE;
}
