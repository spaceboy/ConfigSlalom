<?php

namespace Spaceboy\ConfigSlalom;

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
     * @return Slalom
     */
    public function when()
    {
        $this->chain[]  = $this->active = new ConfigSegment();
        return $this;
    }

    /**
     * @return Slalom
     */
    public function otherwise()
    {
        $this->when();
        $this->active->isOtherwise  = TRUE;
        return $this;
    }

    /**
     * @return Slalom
     */
    public function finally()
    {
        $this->when();
        $this->active->isFinally    = TRUE;
        return $this;
    }

    /**
     * @param string serverName
     * @return Slalom
     */
    public function serverNameIs($name)
    {
        $this->active->condition[]  = function () use ($name) {
            return ($name === $_SERVER['SERVER_NAME']);
        };
        return $this;
    }

    /**
     * @param string serverName
     * @return Slalom
     */
    public function serverNameIsNot($name)
    {
        $this->active->condition[]  = function () use ($name) {
            return ($name !== $_SERVER['SERVER_NAME']);
        };
        return $this;
    }

    /**
     * @param array of string: serverNames
     * @return Slalom
     */
    public function serverNameIsIn($names)
    {
        $this->active->condition[]  = function () use ($names) {
            return in_array($_SERVER['SERVER_NAME'], $names);
        };
        return $this;
    }

    /**
     * @param array of string: serverNames
     * @return Slalom
     */
    public function serverNameNotIn($names)
    {
        $this->active->condition[]  = function () use ($names) {
            return !in_array($_SERVER['SERVER_NAME'], $names);
        };
        return $this;
    }

    /**
     * @param string serverName
     * @return Slalom
     */
    public function serverNameMatches($pattern)
    {
        $this->active->condition[]  = function () use ($pattern) {
            return (bool)preg_match("#{$pattern}#", $_SERVER['SERVER_NAME']);
        };
        return $this;
    }

    /**
     * @param string serverName
     * @return Slalom
     */
    public function serverNameNotMatches($pattern)
    {
        $this->active->condition[]  = function () use ($pattern) {
            return !(bool)preg_match("#{$pattern}#", $_SERVER['SERVER_NAME']);
        };
        return $this;
    }

    /**
     * @param string request URI
     * @return Slalom
     */
    public function requestUriIs($name)
    {
        $this->active->condition[]  = function () use ($name) {
            return ($name === $_SERVER['REQUEST_URI']);
        };
        return $this;
    }

    /**
     * @param string request URI
     * @return Slalom
     */
    public function requestUriStarts($name)
    {
        $this->active->condition[]  = function () use ($name) {
            return (0 === strpos($_SERVER['REQUEST_URI'], $name));
        };
        return $this;
    }

    /**
     * @param string request URI
     * @return Slalom
     */
    public function requestUriContains($name)
    {
        $this->active->condition[]  = function () use ($name) {
            return (FALSE !== strpos($_SERVER['REQUEST_URI'], $name));
        };
        return $this;
    }

    /**
     * @param string request URI
     * @return Slalom
     */
    public function requestUriNotContains($name)
    {
        $this->active->condition[]  = function () use ($name) {
            return (FALSE === strpos($_SERVER['REQUEST_URI'], $name));
        };
        return $this;
    }

    /**
     * @param string request method
     * @return Slalom
     */
    public function requestMethodIs($name)
    {
        $this->active->condition[]  = function () use ($name) {
            return ($name === $_SERVER['REQUEST_METHOD']);
        };
        return $this;
    }

    /**
     * @param string request method
     * @return Slalom
     */
    public function requestMethodIsNot($name)
    {
        $this->active->condition[]  = function () use ($name) {
            return ($name !== $_SERVER['REQUEST_METHOD']);
        };
        return $this;
    }

    /**
     * @param array of string: request method
     * @return Slalom
     */
    public function requestMethodIsIn($name)
    {
        $this->active->condition[]  = function () use ($name) {
            return in_array($_SERVER['REQUEST_METHOD'], $name);
        };
        return $this;
    }

    /**
     * @param array of string: request methods
     * @return Slalom
     */
    public function requestMethodNotIn($name)
    {
        $this->active->condition[]  = function () use ($name) {
            return !in_array($_SERVER['REQUEST_METHOD'], $name);
        };
        return $this;
    }

    /**
     * @param callable callback
     * @return Slalom
     */
    public function isTrue($callable)
    {
        $this->active->condition[]  = $callable;
        return $this;
    }

    /**
     * @param string: port
     * @return Slalom
     */
    public function portIs($ports)
    {
        $this->active->condition[]  = function () use ($port) {
            return ($port == $_SERVER['SERVER_PORT']);
        };
        return $this;
    }

    /**
     * @param string: port
     * @return Slalom
     */
    public function portIsNot($ports)
    {
        $this->active->condition[]  = function () use ($port) {
            return ($port != $_SERVER['SERVER_PORT']);
        };
        return $this;
    }

    /**
     * @param array of strings: list of ports
     * @return Slalom
     */
    public function portIsIn($ports)
    {
        $this->active->condition[]  = function () use ($ports) {
            return in_array($_SERVER['SERVER_PORT'], $ports);
        };
        return $this;
    }

    /**
     * @param array of strings: list of ports
     * @return Slalom
     */
    public function portIsNotIn($ports)
    {
        $this->active->condition[]  = function () use ($ports) {
            return !in_array($_SERVER['SERVER_PORT'], $ports);
        };
        return $this;
    }

    /**
     * @param string protocol
     * @return Slalom
     */
    public function protocolIs($protocol)
    {
        $this->active->condition[]  = function () use ($protocol) {
            return ($protocol === $_SERVER['SERVER_PROTOCOL']);
        };
        return $this;
    }

    /**
     * @param string: protocol
     * @return Slalom
     */
    public function protocolIsNot($ports)
    {
        $this->active->condition[]  = function () use ($protocol) {
            return ($protocol !== $_SERVER['SERVER_PROTOCOL']);
        };
        return $this;
    }

    /**
     * @param array of strings: list of protocols
     * @return Slalom
     */
    public function protocolIsIn($protocols)
    {
        $this->active->condition[]  = function () use ($protocols) {
            return in_array($_SERVER['SERVER_PROTOCOL'], $protocols);
        };
        return $this;
    }

    /**
     * @param array of strings: list of protocols
     * @return Slalom
     */
    public function protocolIsNotIn($protocols)
    {
        $this->active->condition[]  = function () use ($protocols) {
            return !in_array($_SERVER['SERVER_PROTOCOL'], $protocols);
        };
        return $this;
    }

    /**
     * @return Slalom
     */
    public function andContinue()
    {
        $this->active->continue = TRUE;
        return $this;
    }

    /**
     * @param bool $skip
     * @return Slalom
     */
    public function skip($skip = TRUE)
    {
        $this->active->skip     = (bool)$skip;
        return $this;
    }

    /**
     * @return Slalom
     */
    public function throw($throwable)
    {
        $this->active->action[] = function () use ($throwable) {
            throw $throwable;
        };
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
