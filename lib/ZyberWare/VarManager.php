<?php
/**
 * Copyright 2013 Eric Enold <zyberspace@zyberware.org>
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */
namespace ZyberWare;

/**
 * VarManager provides an easy way to save variables with getter- and setter-methods.
 */
class VarManager
{
    /**
     * Stores all variables.
     *
     * @var array
     */
    protected $_vars = array();

    /**
     * Mapper for calls like setMyVariable() and getMyVariable() to $this->set() and $this->get().
     *
     * @param string $call The method-name called
     * @param array $arguments The arguments passed
     *
     * @throws VarManagerException Throws an exception if the called method-name does not start with "set" or "get".
     *
     * @return VarManager|mixed $this if mapped to $this->set(), $value if mapped to $this->get().
     */
    public function __call($call, $arguments)
    {
        $methodName = substr($call, 0, 3);
        if ($methodName !== 'set' && $methodName !== 'get' || strlen($call) <= 3) {
            throw new VarManagerException('Unknown method ' . $call . ' in ' . get_class($this));
        }

        return call_user_func_array(array($this, $methodName), array_merge(array(substr($call, 3)), $arguments));
    }

    /**
     * Can be called in two ways: set($varName, $value) or set($varName, $key, $value).
     *
     * @param string $varName Under which name should $value be saved?
     * @param mixed $value The value of the variable to be saved.
     *
     * @return VarManager $this
     */
    public function set($varName, $value)
    {
        if (func_num_args() > 2) {
            $key = $value;
            $value = func_get_arg(2);
            if (!isset($this->_vars[$varName])) {
                $this->_vars[$varName] = array();
            } elseif (!is_array($this->_vars[$varName])) {
                $this->_vars[$varName] = array($this->_vars[$varName]);
            }
            $this->_vars[$varName][$key] = $value;
        } else {
            $this->_vars[$varName] = $value;
        }
        return $this;
    }

    /**
     * Can be called in two ways: get($varName) or get($varName, $key).
     *
     * @param string $varName The name of the requested variable
     *
     * @return mixed The value of the requested variable
     */
    public function get($varName)
    {
        $var = isset($this->_vars[$varName]) ? $this->_vars[$varName] : null;
        if (func_num_args() > 1 && is_array($var)) {
            $key = func_get_arg(1);
            return isset($var[$key]) ? $var[$key] : null;
        } else {
            return $var;
        }
    }
}
