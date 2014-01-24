<?php
/**
 * This application component is used to check whether a site is online.
 * It offers the option of using the cURL library or raw socket connection code to connect to a given URL and perform
 * an HTTP request to test the site.
 *
 * Only the header of the site is retrieved in order to save load and bandwidth on the target server.
 */

class CheckSite extends CApplicationComponent {

    public static $CURL = 1;
    public static $SOCKET = 2;

    /**
     * Checks whether a site is online.
     *
     * @param $url string URL of the site to check
     * @param $timeout int Number of seconds to wait for a response from the site
     * @param $method int The type of check to use. Should be CheckSite::$CURL (default) or CheckSite::$SOCKET
     * @return bool true if the site returns an HTTP 2XX OK response within the timeout value
     */
    public function isOnline($url, $timeout = 10, $method = 2) {
        switch ($method) {
            case CheckSite::$CURL:
                return $this->isOnlineCurl($url, $timeout);

            case CheckSite::$SOCKET:
                return $this->isOnlineSocket($url, $timeout);
        }

        throw new Exception('Unknown check site method: ' . $method);
    }

    /**
     * Checks whether a site is online using the cURL library.
     *
     * @param $url string URL of the site to check
     * @param $timeout int Number of seconds to wait for a response from the site
     * @return bool true if the site returns an HTTP 2XX OK response within the timeout value
     */
    protected function isOnlineCurl($url, $timeout) {
        try {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            $httpCode = (string)$httpCode;

            if (empty($httpCode) || $httpCode[0] != '2') { // Things are ok if the HTTP response code is 2xx
                return false;
            }

            return true;
        }
        catch (Exception $e) {
            Yii::log("Exception in CheckSite->isOnlineCurl($url, $timeout): " . $e, CLogger::LEVEL_ERROR, 'components.CheckSite');
            return false;
        }
    }

    /**
     * Checks whether a site is online using raw sockets code.
     *
     * @param $url string URL of the site to check
     * @param $timeout int Number of seconds to wait for a response from the site
     * @return bool true if the site returns an HTTP 2XX OK response within the timeout value
     */
    protected function isOnlineSocket($url, $timeout) {
        try {
            $urlParsed = parse_url($url);

            $host = $urlParsed['host'];
            if ($url == '' || $host == '') {
                return false;
            }

            $port = 80;
            if (!empty($urlParsed['port'])) {
                $port = $urlParsed['port'];
            }

            $path = empty($urlParsed['path']) ? '/' : $urlParsed['path'];
            $path .= !empty($urlParsed['query']) ? '?' . $urlParsed['query'] : '';
            $out = "GET $path HTTP/1.0\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "\r\n";

            $errno = null;
            $errstr = null;

            $fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
            if ($fp === FALSE) {
                return false;
            }
            fwrite($fp, $out);
            $headers = '';
            $isBody = false;

            while (!feof($fp) and !$isBody) {
                $buf = fgets($fp, 1024);

                if ($buf == "\r\n") {
                    $isBody = true;
                }
                else {
                    $headers .= $buf;
                }
            }

            fclose($fp);
            $headers = explode("\r\n", $headers);

            // Strip the "HTTP/X.X " prefix and any string suffix from the HTTP response
            $httpResponse = preg_replace('#^HTTP/[0-9]\.[0-9]\s+#i ', '', $headers[0]);
            $httpResponseCode = substr($httpResponse, 0, strpos($httpResponse, ' '));

            // Things are ok if the HTTP response code is 2xx
            if (!empty($httpResponseCode) && $httpResponseCode[0] == '2') {
                return true;
            }
            else if ($httpResponseCode == 301 || $httpResponseCode == 302) {
                // Request the URL from the new location (which is in the "Location:" header)
                $newLocation = '';
                foreach ($headers as $header) {
                    if (stripos($header, 'Location:') === 0)
                        $newLocation = trim(substr($header, strpos($header, ':') + 1));
                }

                if (empty($newLocation)) {
                    throw new Exception('Received HTTP response ' . $httpResponse . ' when attempting to connect to ' . $url . ' but could not find the new location.');
                }

                return $this->isOnlineSocket($newLocation, $timeout);
            }

            return false;
        }
        catch (Exception $e) {
            Yii::log("Exception in CheckSite->isOnlineSocket($url, $timeout): " . $e, CLogger::LEVEL_ERROR, 'components.CheckSite');
            return false;
        }
    }
}
?>
