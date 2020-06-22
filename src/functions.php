<?php
if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}

if (! function_exists('load_test_env')) {
    function load_test_env()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1).'/tests');
        $dotenv->load();
    }
}
