<?php

/*
 * This file is part of Shunt.
 *
 * (c) Taufan Aditya <toopay@taufanaditya.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Shunt;

use League\Shunt\Contracts\SFTPInterface;
use League\Shunt\BaseObject;
use League\Shunt\Contracts\SessionInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Shunt SFTP class
 *
 * @author Taufan Aditya <toopay@taufanaditya.com>
 */
class SFTP extends BaseObject implements SFTPInterface
{
    /**
     * @var resource
     */
    protected $sftp;

    /**
     * Constructor
     *
     * @param SessionInterface
     * @param OutputInterface
     * @throws RuntimeException
     */
    public function __construct(SessionInterface $session, OutputInterface $output)
    {
        // Set the base object properties
        parent::__construct($session, $output);

        if ( ! $session->valid()) throw new RuntimeException('SSH connection failed.');

        $this->sftp = ssh2_sftp($session->getConnection());
    }

    /**
     * @{inheritDoc}
     */
    public function chmod($filename = '', $mode = 0644)
    {
        return $this->doRun(__METHOD__, func_get_args(), ssh2_sftp_chmod($this->sftp, $filename, $mode));
    }

    /**
     * @{inheritDoc}
     */
    public function lstat($path = '')
    {
        return $this->doRun(__METHOD__, func_get_args(), ssh2_sftp_lstat($this->sftp, $path));
    }

    /**
     * @{inheritDoc}
     */
    public function stat($path = '')
    {
        return $this->doRun(__METHOD__, func_get_args(), ssh2_sftp_stat($this->sftp, $path));
    }

    /**
     * @{inheritDoc}
     */
    public function mkdir($dirname = '', $mode = 0777, $recursive = false)
    {
        return $this->doRun(__METHOD__, func_get_args(), ssh2_sftp_mkdir($this->sftp, $dirname, $mode, $recursive));
    }

     /**
     * @{inheritDoc}
     */
    public function rmdir($dirname = '')
    {
        return $this->doRun(__METHOD__, func_get_args(), ssh2_sftp_rmdir($this->sftp, $dirname));
    }

    /**
     * @{inheritDoc}
     */
    public function symlink($target = '',$link = '')
    {
        return $this->doRun(__METHOD__, func_get_args(), ssh2_sftp_symlink($this->sftp, $target, $link));
    }

    /**
     * @{inheritDoc}
     */
    public function readlink($link = '')
    {
        return $this->doRun(__METHOD__, func_get_args(), ssh2_sftp_readlink($this->sftp, $link));
    }

    /**
     * @{inheritDoc}
     */
    public function realpath($filename = '')
    {
        return $this->doRun(__METHOD__, func_get_args(), ssh2_sftp_realpath($this->sftp, $filename));
    }

    /**
     * @{inheritDoc}
     */
    public function rename($from = '', $to = '')
    {
        return $this->doRun(__METHOD__, func_get_args(), ssh2_sftp_rename($this->sftp, $from, $to));
    }

    /**
     * @{inheritDoc}
     */
    public function unlink($filename = '')
    {
        return $this->doRun(__METHOD__, func_get_args(), ssh2_sftp_unlink($this->sftp, $filename));
    }
}
