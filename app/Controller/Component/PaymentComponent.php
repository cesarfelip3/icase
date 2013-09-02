<?php

class PaymentComponent extends Component {

    public $controller;
    public $_error = array(
        "error" => 0,
        "message" => "",
        "data" => null,
    );
    protected $_authorizenet_login = "9c22BSeN";
    protected $_authorizenet_secrect = "752eHX2G6hk9Y36J";

    function authorizenet($data, &$result) {

        if (empty($data)) {
            $this->_error['error'] = 1;
            $this->_error['message'] = "Empty payment data";
            $result = $this->_error;
            return false;
        }

        if (!array_key_exists('amount', $data)) {
            $this->_error['error'] = 1;
            $this->_error['message'] = "Invalid payment data";
            $result = $this->_error;
            return false;
        }

        if (!array_key_exists('card', $data)) {
            $this->_error['error'] = 1;
            $this->_error['message'] = "Invalid payment data";
            $result = $this->_error;
            return false;
        }

        require_once APP . 'Vendor' . DS . 'AuthorizeNet/AuthorizeNet.php';

        define("AUTHORIZENET_SANDBOX", false);
        $transaction = new AuthorizeNetAIM($this->_authorizenet_login, $this->_authorizenet_secrect);
        $transaction->setSandbox(false);

        $transaction->amount = $data['amount'];
        $transaction->card_num = $data['card']['cc_number']; //4007000000027 - 10/16
        $transaction->exp_date = $data['card']['cc_expired']['month'] . "/" . $data['card']['cc_expired']['year'];

        $response = $transaction->authorizeAndCapture();

        if ($response->approved) {
            $this->_error['data']['trans_id'] = $response->transaction_id;
            $this->_error['data']['trans_type'] = $response->transaction_type;
        } else {
            $this->autoRender = false;
            $this->_error['error'] = 1;
            $this->_error['message'] = $response->error_message;
            return false;
        }

        $this->_error['data']['object'] = $response;
        $result = $this->error;
        return true;
    }

}

?>