<?php

/**
 * Description of Paypal
 *
 * @author turi
 */
class Paypal extends CComponent {

    const PAYPAL_PRODUCTION = 'https://www.paypal.com/cgi-bin/webscr';
    const ENDPOINT_PRODUCTION = 'https://api-3t.paypal.com/nvp';
    const PAYPAL_SANDBOX = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    const ENDPOINT_SANDBOX = 'https://api-3t.sandbox.paypal.com/nvp';

    /**
      # The url (relative to base url) to return the customer after a successful payment
     */
    public $returnUrl;

    /**
      # The url (relative to base url) to return the customer if he/she cancels the payment
     */
    public $cancelUrl;

    /**
     * @var string|array The url to notify url for the paypal
     */
    public $notifyUrl;

    /**
      # Default currency to use;
     */
    public $currency = CURRENCY;

    /**
      # Endpoint: this is the server URL which you have to connect for submitting your API request.
     */
    public $endPoint;

    /* Define the PayPal URL. This is the URL that the buyer is 
      first sent to to authorize payment with their paypal account
      change the URL depending if you are testing on the sandbox
      or going to the live PayPal site
      For the sandbox, the URL is
      https://www.sandbox.paypal.com/cgi-bin/webscr
      For the live site, the URL is
      https://www.paypal.com/cgi-bin/webscr
     */
    public $paypalUrl;

    /**
     * @var string paypal business/merchant email
     */
    public $businessEmail = BUSINESSEMAIL;
    public $paypalSandbox = SANDBOXVALUE;
    public $lastError;                 // holds the last error encountered
    public $ipnResponse;               // holds the IPN response from paypal   
    public $ipnData = array();         // array contains the POST values for IPN
    public $fields = array();           // array holds the fields to submit to paypal

    public function init() {
        
    }

    public function __construct() {
        if ((bool) $this->paypalSandbox === false) {
            $this->paypalUrl = self::PAYPAL_PRODUCTION;
            $this->endPoint = self::ENDPOINT_PRODUCTION;
        } else {
            $this->paypalUrl = self::PAYPAL_SANDBOX;
            $this->endPoint = self::ENDPOINT_SANDBOX;
        }
    }

    public function addField($field, $value) {

        // adds a key=>value pair to the fields array, which is what will be 
        // sent to paypal as POST variables.  If the value is already in the 
        // array, it will be overwritten.

        $this->fields["$field"] = $value;
    }

    public function submitPaypalPost() {

        $this->addField('rm', '2');           // Return method = POST
        $this->addField('cmd', '_xclick');
        $this->addField('business', $this->businessEmail);
        $this->addField('currency_code', $this->currency);


        // this function actually generates an entire HTML page consisting of
        // a form with hidden elements which is submitted to paypal via the 
        // BODY element's onLoad attribute.  We do this so that you can validate
        // any POST vars from you custom form before submitting to paypal.  So 
        // basically, you'll have your own form which is submitted to your script
        // to validate the data, which in turn calls this function to create
        // another hidden form and submit to paypal.
        // The user will briefly see a message on the screen that reads:
        // "Please wait, your order is being processed..." and then immediately
        // is redirected to paypal.

        echo "<html>\n";
        echo "<head><title>" . Myclass::t('OGO135', '', 'og') . "</title></head>\n";
        // echo "<body>";
        echo "<body onLoad=\"document.form.submit();\">\n";
        echo "<center><h3>" . Myclass::t('OGO136', '', 'og') . "</h3></center>\n";
        echo "<form method=\"post\" name=\"form\" action=\"" . $this->paypalUrl . "\">\n";

        foreach ($this->fields as $name => $value) {
            echo "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
        }

        echo "</form>\n";
        echo "</body></html>\n";
        exit;
    }

    public function notify() {

        $listener = new IpnListener();
        $listener->use_curl = false;
        $listener->use_sandbox = $this->paypalSandbox;

        return $listener->processIpn();
    }

    public function dumpFields() {

        // Used for debugging, this function will output all the field/value pairs
        // that are currently defined in the instance of the class using the
        // addField() function.

        echo "<h3>paypal_class->dumpFields() Output:</h3>";
        echo "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\">
            <tr>
               <td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>
               <td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td>
            </tr>";

        ksort($this->fields);
        foreach ($this->fields as $key => $value) {
            echo "<tr><td>$key</td><td>" . urldecode($value) . "&nbsp;</td></tr>";
        }

        echo "</table><br>";
    }

}

?>
