<?php
return array(
    // set your paypal credential
    'client_id' => 'AV_ndTenqvdacG7UfI-5mUTcs_23fFi6c7SUpX3k7uPl2-fqFntmohv7j2HKlzpNtkr9R9ErsXvsdqCH',
    'secret' => 'EKbLLF_NOfMarzX4jrRfp22QLKCenSkMgCB-32L8nNYkmd9ys3u3fts3yl3wkj2xAH5D0BvX7z--zGfe',
 
    /**
     * SDK configuration 
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',
 
        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,
 
        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,
 
        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',
 
        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);

?>