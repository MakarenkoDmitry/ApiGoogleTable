<?php
require  'vendor/autoload.php';
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;

class ApiGoogleTable {
    private $client;
    private $accessToken = null;
    private $spreadsheet = null;
    private $worksheets = null;
    private $worksheet = null;

    function __construct($nameServiceKey) {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/' . $nameServiceKey);
        $this->init();
    }

    function init() {
        $this->client = new Google_Client;
        $this->client->useApplicationDefaultCredentials();
        $this->client->setApplicationName("Something to do with my representatives");
        $this->client->setScopes(['https://www.googleapis.com/auth/drive','https://spreadsheets.google.com/feeds']);
        if ($this->client->isAccessTokenExpired()) {
            $this->client->refreshTokenWithAssertion();
        }
        $this->accessToken = $this->client->fetchAccessTokenWithAssertion()["access_token"];
        ServiceRequestFactory::setInstance(
            new DefaultServiceRequest($this->accessToken)
        );
    }

    function setTable($nameTable) {
        $this->spreadsheet = (new Google\Spreadsheet\SpreadsheetService)
            ->getSpreadsheetFeed()
            ->getByTitle($nameTable);
        $this->worksheets = $this->spreadsheet->getWorksheetFeed()->getEntries();
        $this->worksheet = $this->worksheets[0];
    }

    function sendData ($data) {
        $listFeed = $this->worksheet->getListFeed();
        $listFeed->insert($data);
    }
}
