<?php

namespace Spaceboy\ConfigSlalom;

if (!defined('PHP_VERSION_ID')) {
    $v = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($v[0] * 10000) + ($v[1] * 100) + $v[2]);
}

class Slalom
{
    /** @var Configurator */
    protected   $configurator;

    /** @var array of ConfigSegment */
    protected   $chain  = array();

    /** @var ConfigSegment */
    protected   $active;

    /** @var ConfigSegment */
    protected   $otherwise;

    /** @var ConfigSegment */
    protected   $finally;

    /** @var boolean */
    protected   $apply;

    /**
     * Slalom class constructor.
     * @param mixed $configurator
     */
    protected function __construct($configurator)
    {
        $this->configurator = $configurator;
    }

    /**
     * Get plain Slalom instantion
     */
    public static function start($configurator = NULL)
    {
        return new static($configurator);
    }

    /**
     * DIRECTIVE: Starts new clause.
     * @param bool $apply [=TRUE]
     * @return Slalom
     */
    public function when($apply = TRUE)
    {
        if ($this->apply = $apply) {
            $this->chain[]  = $this->active = new ConfigSegment();
        }
        return $this;
    }

    /**
     * DIRECTIVE: Starts "otherwise" clause
     * @param bool $apply [=TRUE]
     * @return Slalom
     */
    public function otherwise($apply = TRUE)
    {
        if ($this->apply = $apply) {
            $this->when($apply);
            $this->active->isOtherwise  = TRUE;
        }
        return $this;
    }

    /**
     * DIRECTIVE: Starts "finally" clause
     * @param bool $apply [=TRUE]
     * @return Slalom
     */
    public function finally($apply = TRUE)
    {
        if ($this->apply = $apply) {
            $this->when($apply);
            $this->active->isFinally    = TRUE;
        }
        return $this;
    }

    /**
     * @param string serverName
     * @return Slalom
     */
    public function serverNameIs($name)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($name) {
                return (isset($_SERVER['SERVER_NAME']) && $name === $_SERVER['SERVER_NAME']);
            };
        }
        return $this;
    }

    /**
     * @param string serverName
     * @return Slalom
     */
    public function serverNameIsNot($name)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($name) {
                return (isset($_SERVER['SERVER_NAME']) && $name !== $_SERVER['SERVER_NAME']);
            };
        }
        return $this;
    }

    /**
     * @param array of string: serverNames
     * @return Slalom
     */
    public function serverNameIsIn($names)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($names) {
                return in_array(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'], $names);
            };
        }
        return $this;
    }

    /**
     * @param array of string: serverNames
     * @return Slalom
     */
    public function serverNameNotIn($names)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($names) {
                return !in_array(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'], $names);
            };
        }
        return $this;
    }

    /**
     * @param string serverName
     * @return Slalom
     */
    public function serverNameMatches($pattern)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($pattern) {
                return (isset($_SERVER['SERVER_NAME']) && (bool)preg_match("#{$pattern}#", $_SERVER['SERVER_NAME']));
            };
        }
        return $this;
    }

    /**
     * @param string serverName
     * @return Slalom
     */
    public function serverNameNotMatches($pattern)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($pattern) {
                return (isset($_SERVER['SERVER_NAME']) && !(bool)preg_match("#{$pattern}#", $_SERVER['SERVER_NAME']));
            };
        }
        return $this;
    }

    /**
     * @param string request URI
     * @return Slalom
     */
    public function requestUriIs($name)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($name) {
                return (isset($_SERVER['REQUEST_URI']) && $name === $_SERVER['REQUEST_URI']);
            };
        }
        return $this;
    }

    /**
     * @param string request URI
     * @return Slalom
     */
    public function requestUriStarts($name)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($name) {
                return (isset($_SERVER['REQUEST_URI']) && 0 === strpos($_SERVER['REQUEST_URI'], $name));
            };
        }
        return $this;
    }

    /**
     * @param string request URI
     * @return Slalom
     */
    public function requestUriContains($name)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($name) {
                return (isset($_SERVER['REQUEST_URI']) && FALSE !== strpos($_SERVER['REQUEST_URI'], $name));
            };
        }
        return $this;
    }

    /**
     * @param string request URI
     * @return Slalom
     */
    public function requestUriNotContains($name)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($name) {
                return (isset($_SERVER['REQUEST_URI']) && FALSE === strpos($_SERVER['REQUEST_URI'], $name));
            };
        }
        return $this;
    }

    /**
     * @param string request method
     * @return Slalom
     */
    public function requestMethodIs($name)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($name) {
                return (isset($_SERVER['REQUEST_METHOD']) && $name === $_SERVER['REQUEST_METHOD']);
            };
        }
        return $this;
    }

    /**
     * @param string request method
     * @return Slalom
     */
    public function requestMethodIsNot($name)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($name) {
                return (isset($_SERVER['REQUEST_METHOD']) && $name !== $_SERVER['REQUEST_METHOD']);
            };
        }
        return $this;
    }

    /**
     * @param array of string: request method
     * @return Slalom
     */
    public function requestMethodIsIn($name)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($name) {
                return (isset($_SERVER['REQUEST_METHOD']) && in_array($_SERVER['REQUEST_METHOD'], $name));
            };
        }
        return $this;
    }

    /**
     * @param array of string: request methods
     * @return Slalom
     */
    public function requestMethodNotIn($name)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($name) {
                return (isset($_SERVER['REQUEST_METHOD']) && !in_array($_SERVER['REQUEST_METHOD'], $name));
            };
        }
        return $this;
    }

    /**
     * @param callable callback
     * @return Slalom
     */
    public function isTrue($callable)
    {
        if ($this->apply) {
            $configurator   = $this->configurator;
            $this->active->condition[]  = function () use ($callable, $configurator) {
                return call_user_func_array($callable, array($configurator));
            };
        }
        return $this;
    }

    /**
     * @param string: port
     * @return Slalom
     */
    public function portIs($ports)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($port) {
                return (isset($_SERVER['SERVER_PORT']) && $port == $_SERVER['SERVER_PORT']);
            };
        }
        return $this;
    }

    /**
     * @param string: port
     * @return Slalom
     */
    public function portIsNot($ports)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($port) {
                return (isset($_SERVER['SERVER_PORT']) && $port != $_SERVER['SERVER_PORT']);
            };
        }
        return $this;
    }

    /**
     * @param array of strings: list of ports
     * @return Slalom
     */
    public function portIsIn($ports)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($ports) {
                return (isset($_SERVER['SERVER_PORT']) && in_array($_SERVER['SERVER_PORT'], $ports));
            };
        }
        return $this;
    }

    /**
     * @param array of strings: list of ports
     * @return Slalom
     */
    public function portIsNotIn($ports)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($ports) {
                return (isset($_SERVER['SERVER_PORT']) && !in_array($_SERVER['SERVER_PORT'], $ports));
            };
        }
        return $this;
    }

    /**
     * @param string protocol
     * @return Slalom
     */
    public function protocolIs($protocol)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($protocol) {
                return (isset($_SERVER['SERVER_PROTOCOL']) && $protocol === $_SERVER['SERVER_PROTOCOL']);
            };
        }
        return $this;
    }

    /**
     * @param string: protocol
     * @return Slalom
     */
    public function protocolIsNot($ports)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($protocol) {
                return (isset($_SERVER['SERVER_PROTOCOL']) && $protocol !== $_SERVER['SERVER_PROTOCOL']);
            };
        }
        return $this;
    }

    /**
     * @param array of strings: list of protocols
     * @return Slalom
     */
    public function protocolIsIn($protocols)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($protocols) {
                return (isset($_SERVER['SERVER_PROTOCOL']) && in_array($_SERVER['SERVER_PROTOCOL'], $protocols));
            };
        }
        return $this;
    }

    /**
     * @param array of strings: list of protocols
     * @return Slalom
     */
    public function protocolIsNotIn($protocols)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($protocols) {
                return (isset($_SERVER['SERVER_PROTOCOL']) && !in_array($_SERVER['SERVER_PROTOCOL'], $protocols));
            };
        }
        return $this;
    }

    /**
     * @param integer $phpVersion
     * @return Slalom
     */
    public function phpVersionIs($phpVersion)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($phpVersion) {
                return (PHP_VERSION_ID == $phpVersion);
            };
        }
        return $this;
    }

    /**
     * @param integer $phpVersion
     * @return Slalom
     */
    public function phpVersionIsNot($phpVersion)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($phpVersion) {
                return (PHP_VERSION_ID != $phpVersion);
            };
        }
        return $this;
    }

    /**
     * @param integer[] $phpVersions
     * @return Slalom
     */
    public function phpVersionIsIn($phpVersions)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($phpVersions) {
                return in_array(PHP_VERSION_ID, $phpVersions);
            };
        }
        return $this;
    }

    /**
     * @param integer[] $phpVersions
     * @return Slalom
     */
    public function phpVersionIsNotIn($phpVersions)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($phpVersions) {
                return !in_array(PHP_VERSION_ID, $phpVersions);
            };
        }
        return $this;
    }

    /**
     * @param integer $phpVersion
     * @return Slalom
     */
    public function phpVersionBG($phpVersion)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($phpVersion) {
                return (PHP_VERSION_ID > $phpVersion);
            };
        }
        return $this;
    }

    /**
     * @param integer $phpVersion
     * @return Slalom
     */
    public function phpVersionBE($phpVersion)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($phpVersion) {
                return (PHP_VERSION_ID >= $phpVersion);
            };
        }
        return $this;
    }

    /**
     * @param integer $phpVersion
     * @return Slalom
     */
    public function phpVersionEQ($phpVersion)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($phpVersion) {
                return (PHP_VERSION_ID == $phpVersion);
            };
        }
        return $this;
    }

    /**
     * @param integer $phpVersion
     * @return Slalom
     */
    public function phpVersionNE($phpVersion)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($phpVersion) {
                return (PHP_VERSION_ID != $phpVersion);
            };
        }
        return $this;
    }

    /**
     * @param integer $phpVersion
     * @return Slalom
     */
    public function phpVersionLE($phpVersion)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($phpVersion) {
                return (PHP_VERSION_ID <= $phpVersion);
            };
        }
        return $this;
    }

    /**
     * @param integer $phpVersion
     * @return Slalom
     */
    public function phpVersionLT($phpVersion)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($phpVersion) {
                return (PHP_VERSION_ID < $phpVersion);
            };
        }
        return $this;
    }

    /**
     * @param string $sapi
     * @return Slalom
     */
    public function phpSapiIs($sapi)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($sapi) {
                return (PHP_SAPI == $sapi);
            };
        }
        return $this;
    }

    /**
     * @param string $sapi
     * @return Slalom
     */
    public function phpSapiIsNot($sapi)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($sapi) {
                return (PHP_SAPI != $sapi);
            };
        }
        return $this;
    }

    /**
     * @param string[] $sapi
     * @return Slalom
     */
    public function phpSapiIsIn($sapi)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($sapi) {
                return in_array(PHP_SAPI, $sapi);
            };
        }
        return $this;
    }

    /**
     * @param string[] $sapi
     * @return Slalom
     */
    public function phpSapiNotIn($sapi)
    {
        if ($this->apply) {
            $this->active->condition[]  = function () use ($sapi) {
                return !in_array(PHP_SAPI, $sapi);
            };
        }
        return $this;
    }

    /**
     * DIRECTIVE
     * @return Slalom
     */
    public function andContinue()
    {
        if ($this->apply) {
            $this->active->continue     = TRUE;
        }
        return $this;
    }

    /**
     * DIRECTIVE
     * @param bool $skip
     * @return Slalom
     */
    public function skip($skip = TRUE)
    {
        if ($this->apply) {
            $this->active->skip         = (bool)$skip;
        }
        return $this;
    }

    /**
     * DIRECTIVE
     * @return Slalom
     */
    public function throw($throwable)
    {
        if ($this->apply) {
            $this->active->action[]     = function () use ($throwable) {
                throw $throwable;
            };
        }
        return $this;
    }

    /**
     * @param callable $callable
     * @param array $args
     * @return Slalom
     */
    public function execute($callable, $args = NULL)
    {
        if (1 == func_num_args()) {
            $args   = array($this->configurator);
        } else {
            array_unshift($args, $this->configurator);
        }
        $this->active->action[] = function () use ($callable, $args) {
            call_user_func_array($callable, $args);
        };
        return $this;
    }

    /**
     * @param ConfigSegment segment
     * @return void
     */
    private function executeSegment($segment)
    {
        foreach ($segment->action AS $action) {
            call_user_func($action);
        }
    }

    /**
     * @return mixed $configurator
     */
    public function run()
    {
        $done   = FALSE;
        foreach ($this->chain AS $i => $segment) {
            if ($segment->isOtherwise) {
                $this->otherwise    = $segment;
                unset($this->chain[$i]);
                continue;
            }
            if ($segment->isFinally) {
                $this->finally      = $segment;
                unset($this->chain[$i]);
                continue;
            }
        }
        foreach ($this->chain AS $segment) {
            if ($segment->skip) {
                continue;
            }
            $pass   = FALSE;
            foreach ($segment->condition AS $condition) {
                if (!($pass = call_user_func($condition))) {
                    break;
                }
            }
            if (!$pass) {
                continue;
            }
            $this->executeSegment($segment);
            $done   = TRUE;
            if (!$segment->continue) {
                break;
            }
        }
        if (!$done && $this->otherwise && !$this->otherwise->skip) {
            $this->executeSegment($this->otherwise);
        }
        if ($this->finally && !$this->finally->skip) {
            $this->executeSegment($this->finally);
        }
        return $this->configurator;
    }

}
