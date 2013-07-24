<?php
/**
 * Copyright 2013 Eric Enold <zyberspace@zyberware.org>
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */
namespace ZyberWare\Application;

class VarManager
{
    protected $_vars = array();

    public function __call($call, $arguments)
    {
        $methodName = substr($call, 0, 3);
        if ($methodName !== 'set' && $methodName !== 'get' || strlen($call) <= 3) {
            throw new Exception('Unknown method ' . $call . ' in ' . get_class($this));
        }

        return call_user_func_array(array($this, $methodName), array_merge(array(substr($call, 3)), $arguments));
    }

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
