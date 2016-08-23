<?php

namespace Mattvick\AccessLogs;

/**
 * Parse a single line representing a visit from a W3C extended log file into an array
 *
 * To learn more see {
 *     @link https://www.w3.org/TR/WD-logfile.html
 *     @link http://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/AccessLogs.html
 * }
 *
 * Fields {
 *      date
 *      time
 *      x-edge-location
 *      sc-bytes
 *      c-ip
 *      cs-method
 *      cs(Host)
 *      cs-uri-stem
 *      sc-status
 *      cs(Referer)
 *      cs(User-Agent)
 *      cs-uri-query
 *      cs(Cookie)
 *      x-edge-result-type
 *      x-edge-request-id
 *      x-host-header
 *      cs-protocol
 *      cs-bytes
 *      time-taken
 *      x-forwarded-for
 *      ssl-protocol
 *      ssl-cipher
 *      x-edge-response-result-type
 *      cs-protocol-version
 * }
 *
 * @author Matthew Vickery <vickery.matthew@gmail.com>
 */
class Parser
{
    /**
     * date
     *
     * The date on which the event occurred in the format yyyy-mm-dd, 
     * for example, 2015-06-30. The date and time are in Coordinated Universal Time (UTC).
     *
     * @var string
     */
    const COLUMN_DATE = 0;

    /**
     * time
     *
     * The time when the CloudFront server finished responding to the request (in UTC), 
     * for example, 01:42:39.
     * 
     * @var string
     */
    const COLUMN_TIME = 1;

    /**
     * x-edge-location
     *
     * The edge location that served the request. 
     * Each edge location is identified by a three-letter code and an arbitrarily assigned number, 
     * for example, DFW3. The three-letter code typically corresponds with the International 
     * Air Transport Association airport code for an airport near the edge location. 
     * (These abbreviations might change in the future.) For a list of edge locations, 
     * see the Amazon CloudFront detail page, http://aws.amazon.com/cloudfront.
     * 
     * @var string
     */
    const COLUMN_EDGE_LOCATION = 2;

    /**
     * sc-bytes
     *
     * The total number of bytes that CloudFront served to the viewer in response to the request, 
     * including headers, for example, 1045619.
     * 
     * @var string
     */
    const COLUMN_BYTES = 3;

    /**
     * c-ip
     *
     * The IP address of the viewer that made the request, 
     * for example, 192.0.2.183. If the viewer used an HTTP proxy or a load balancer to 
     * send the request, the value of c-ip is the IP address of the proxy or load balancer. 
     * See also X-Forwarded-For in field 20.
     * 
     * @var string
     */
    const COLUMN_IP = 4;

    /**
     * cs-method
     *
     * The HTTP access method: DELETE, GET, HEAD, OPTIONS, PATCH, POST, or PUT.
     * 
     * @var string
     */
    const COLUMN_METHOD = 5;

    /**
     * cs(Host)
     *
     * The domain name of the CloudFront distribution, 
     * for example, d111111abcdef8.cloudfront.net.
     * 
     * @var string
     */
    const COLUMN_HOST = 6;

    /**
     * cs-uri-stem
     *
     * The portion of the URI that identifies the path and object, 
     * for example, /images/daily-ad.jpg.
     * 
     * @var string
     */
    const COLUMN_URI_STEM = 7;

    /**
     * sc-status
     *
     * One of the following values:
     *
     * - An HTTP status code (for example, 200). For a list of HTTP status codes, 
     *   see RFC 2616, Hypertext Transfer Protocol—HTTP 1.1, section 10, Status Code Definitions. 
     *   For more information, see How CloudFront Processes and Caches HTTP 4xx and 5xx Status Codes 
     *   from Your Origin.
     *
     * - 000, which indicates that the viewer closed the connection (for example, closed the browser tab) 
     *   before CloudFront could respond to a request.
     * 
     * @var string
     */
    const COLUMN_STATUS = 8;

    /**
     * cs(Referer)
     *
     * The name of the domain that originated the request. Common referrers include search engines, 
     * other websites that link directly to your objects, and your own website.
     * 
     * @var string
     */
    const COLUMN_REFERER = 9;

    /**
     * cs(User-Agent)
     *
     * The value of the User-Agent header in the request. The User-Agent header identifies 
     * the source of the request, such as the type of device and browser that submitted the request 
     * and, if the request came from a search engine, which search engine. 
     * For more information, see User-Agent Header.
     * 
     * @var string
     */
    const COLUMN_USER_AGENT = 10;

    /**
     * s-uri-query
     *
     * The query string portion of the URI, if any. When a URI doesn't contain a query string, 
     * the value of cs-uri-query is a hyphen (-).
     *
     * For more information, see Configuring CloudFront to Cache Based on Query String Parameters.
     * 
     * @var string
     */
    const COLUMN_URI_QUERY = 11;

    // cs(Cookie)
    // x-edge-result-type
    // x-edge-request-id
    // x-host-header
    // cs-protocol
    // cs-bytes
    // time-taken
    // x-forwarded-for
    // ssl-protocol
    // ssl-cipher
    // x-edge-response-result-type
    // cs-protocol-version

    /**
     * Parse a visit line from a log file
     * 
     * @param string $line a line from a log file
     * @return \Mattvick\AccessLogs\Line
     */
    public function parse($line)
    {
        $data = str_getcsv($line, "\t");

        return new Line(
            $data[self::COLUMN_DATE],
            $data[self::COLUMN_TIME],
            $data[self::COLUMN_EDGE_LOCATION],
            $data[self::COLUMN_BYTES],
            $data[self::COLUMN_IP],
            $data[self::COLUMN_METHOD],
            $data[self::COLUMN_HOST],
            $data[self::COLUMN_URI_STEM],
            $data[self::COLUMN_STATUS],
            $data[self::COLUMN_REFERER],
            $data[self::COLUMN_USER_AGENT],
            $data[self::COLUMN_URI_QUERY]
        );
    }
}
