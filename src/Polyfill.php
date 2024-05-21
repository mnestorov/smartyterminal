<?php

namespace SmartyStudio\SmartyTerminal
{
    /**
     * @param $argument
     * @return string
     */
    function escapeshellarg($argument): string
    {
        return \SmartyStudio\SmartyTerminal\Services\ProcessUtils::escapeArgument($argument);
    }
}

namespace SebastianBergmann\Environment
{
    /**
     * @param $input
     * @return string
     */
    function escapeshellarg($input): string
    {
        return \SmartyStudio\SmartyTerminal\escapeshellarg($input);
    }
}

namespace Symfony\Component\Console\Input
{
    /**
     * @param $input
     * @return string
     */
    function escapeshellarg($input): string
    {
        return \SmartyStudio\SmartyTerminal\escapeshellarg($input);
    }
}

namespace Symfony\Component\HttpFoundation\File\MimeType
{
    /**
     * @param $input
     * @return mixed
     */
    function escapeshellarg($input): mixed
    {
        return \SmartyStudio\SmartyTerminal\scapeshellarg($input);
    }
}

namespace Symfony\Component\Process
{
    /**
     * @param $input
     * @return string
     */
    function escapeshellarg($input): string
    {
        return \SmartyStudio\SmartyTerminal\escapeshellarg($input);
    }
}
