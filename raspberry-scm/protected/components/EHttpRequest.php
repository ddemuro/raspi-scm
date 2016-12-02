<?php

/*
 * This class is thought to manage the problem with CSFR Cookies, so instead
 * we grab them, process them at cookie time.
 * If there's a problem we'll still rise the CSFR Invalid cookie error.
 */

class EHttpRequest extends CHttpRequest {

    protected $_userLocation;
    public $useReverseProxyHeaders = false;
    private $_csrfToken;

    const IP_ADDRESS_DATABASE = 'http://api.hostip.info/get_json.php';

    public function getIsSecureConnection() {
        $headers = apache_request_headers();
        if (!$this->useReverseProxyHeaders || !isset($headers['X-Forwarded-Proto']))
            return parent::getIsSecureConnection();
        return $headers['X-Forwarded-Proto'] == 'https';
    }

    public function getUserCity() {
        return $this->userLocation['city'];
    }

    protected function getUserLocation() {
        if (!empty($this->_userLocation))
            return $this->_userLocation;
        $client = new EHttpClient(self::IP_ADDRESS_DATABASE);
        $client->setParameterGet('ip', $this->getUserHostAddress());
        $response = $client->request();
        $this->_userLocation = CJSON::decode($response->getBody());
        return $this->_userLocation;
    }

    public function getUserCountryCode() {
        return $this->userLocation['country_code'];
    }

    public function getUserCountryName() {
        return $this->userLocation['country_name'];
    }

    public function getUserHostAddress() {
        $headers = apache_request_headers();
        if (!$this->useReverseProxyHeaders || !isset($headers['X-Forwarded-For']))
            return parent::getUserHostAddress();
        return $headers['X-Forwarded-For'];
    }

    public function getCsrfToken() {
        if ($this->_csrfToken === null) {
            $session = Yii::app()->session;
            $csrfToken = $session->itemAt($this->csrfTokenName);
            if ($csrfToken === null) {
                $csrfToken = sha1(uniqid(mt_rand(), true));
                $session->add($this->csrfTokenName, $csrfToken);
            }
            $this->_csrfToken = $csrfToken;
        }

        return $this->_csrfToken;
    }

    public function validateCsrfToken($event) {
        if ($this->getIsPostRequest()) {
            // only validate POST requests
            $session = Yii::app()->session;
            if ($session->contains($this->csrfTokenName) && isset($_POST[$this->csrfTokenName])) {
                $tokenFromSession = $session->itemAt($this->csrfTokenName);
                $tokenFromPost = $_POST[$this->csrfTokenName];
                $valid = $tokenFromSession === $tokenFromPost;
            } else {
                $valid = false;
            }
            if (!$valid)
                throw new CHttpException(400, Yii::t('yii', 'The CSRF token could not be verified.'));
        }
    }

}

?>