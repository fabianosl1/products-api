<?php
namespace App;
class Logger
{
    private string $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    public function info(string $message): void
    {
        $this->log(LOG_INFO, "INFO", $message, "\e[1,36,0m");
    }


    public function critical(string $message): void
    {
        $this->log(LOG_CRIT, "CRITICAL", $message);
    }

    private function log(int $level, string $levelStr, string $message): void
    {
        $now = date("D M j H:i:s Y");
        openlog("[$now] $this->prefix", LOG_NDELAY|LOG_PERROR, LOG_SYSLOG);
        syslog($level, "$levelStr $message");
        closelog();
    }
}
