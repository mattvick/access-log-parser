<?php

namespace Mattvick\AccessLogs;

/**
 * Represents a log line
 *
 * @author Matthew Vickery <vickery.matthew@gmail.com>
 */
class Line
{
    /**
     * The time zone to use
     * 
     * @var string
     */
    const TIMEZONE = 'UTC';

    /**
     * @var string
     */
    protected $date;

    /**
     * @var string
     */
    protected $time;

    /**
     * @var string
     */
    protected $edgeLocation;

    /**
     * @var string
     */
    protected $bytes;

    /**
     * @var string
     */
    protected $ip;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $uriStem;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $referer;

    /**
     * @var string
     */
    protected $userAgent;

    /**
     * @var string
     */
    protected $uriQuery;


    public function __construct($date, $time, $edgeLocation, $bytes, $ip, $method, $host, $uriStem, $status, $referer, $userAgent, $uriQuery)
    {
        $this->date = $date;
        $this->time = $time;
        $this->edgeLocation = $edgeLocation;
        $this->bytes = $bytes;
        $this->ip = $ip;
        $this->method = $method;
        $this->host = $host;
        $this->uriStem = $uriStem;
        $this->status = $status;
        $this->referer = $referer;
        $this->userAgent = $userAgent;
        $this->uriQuery = $uriQuery;
    }

    /**
     * Get the date
     * 
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get the time
     * 
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Get the created date from the log line data
     * 
     * @return \DateTime
     */
    public function getDateTime()
    {
        $dtStr = $this->date.' '.$this->time;
        $dtz = new \DateTimeZone(self::TIMEZONE);
        return \DateTime::createFromFormat('Y-m-d H:i:s', $dtStr, $dtz);
    }

    /**
     * Get the edge location
     * 
     * @return string
     */
    public function getEdgeLocation()
    {
        return $this->edgeLocation;
    }

    /**
     * Get the bytes
     * 
     * @return integer
     */
    public function getBytes($cast = true)
    {
        if ($cast) {
            return (integer) $this->bytes;
        }
        return $this->bytes;
    }

    /**
     * Get the IP address
     * 
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Get the HTTP method
     * 
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get the host
     * 
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Get the uri stem
     * 
     * @return string
     */
    public function getUriStem()
    {
        return $this->uriStem;
    }

    /**
     * Get the status code
     * 
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the referer
     * 
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * return the URL decoded user agent string
     * 
     * @todo find out why this is double encoded
     * @param boolean $decode
     * @return string - the raw or decoded user agent string
     */
    public function getUserAgent($decode = true)
    {
        if ($decode) {
            return rawurldecode(rawurldecode($this->userAgent));
        }
        return $this->userAgent;
    }

    /**
     * Get the uri query
     * 
     * @return string
     */
    public function getUriQuery()
    {
        return $this->uriQuery;
    }

    /**
     * Get the uri query paramaters
     * 
     * @return string
     */
    public function getUriParameters()
    {
        // This function automatically urldecodes values
        parse_str($this->uriQuery, $params);

        return $params;
    }

}