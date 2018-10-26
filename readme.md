## Installation
Install composer.
 ```
 $ apt-get install composer
 ```
Install package:
 ```
 $ composer install
```

Install php module:
 ```
 $ apt-get install php-xml, 
 $ apt-get install php-simplexml
```



## Usage
1 - Generate "Service account key".
* Go to https://console.developers.google.com/, create new project.
* Add "Api Library" in project
```python
- Google Sheets API;
- Google Drive API;
```
* Create service account key
    * Create service account key
    * Save json file
    
* Paste json file in project folder.

* give access to the table for a client_email who is in json file
* add column names in Google Table
    
2 - Development
```php
require_once("ApiGoogleTable.php");

$googleTable = new ApiGoogleTable("my_secret.json"); // name json file
$googleTable->setTable("MyTable"); // name table in Google Table
$googleTable->sendData([
    'date' => date_create('now')->format('Y-m-d H:i:s'),
    'phone' => "'" . '0000-0000-00000',
    'city' => "'" . 'red',
]); // push data in table
```
