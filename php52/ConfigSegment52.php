<?php

class ConfigSegment
{
    /** @var array list of segment's conditions */
    public  $condition      = array();

    /** @var array list of segment's actions */
    public  $action         = array();

    /** @var bool flag: segment is to continue */
    public  $continue       = FALSE;

    /** @var bool flag: segment is to skip */
    public  $skip           = FALSE;

    /** @var bool flag: segment is Otherwise */
    public  $isOtherwise    = FALSE;

    /** @var bool flag: segment is Finally */
    public  $isFinally      = FALSE;
}
