# About
This is the documentation for the official [Tamkeen LMS](tamkeenlms.com) API client. You can use this API client to do a couple of simple operations like retreiving the programs and submit a program signup request.

# Installation
You can install this library using Composer:
```
composer require tamkeenlms/api
```
Now in your code you will need to intiate the API by setting up the basic request information ie. the API key and the base URI for the API.
```php
TamkeenLMSAPI\Request::$setup['api_key'] = '...' // The API key
TamkeenLMSAPI\Request::$setup['api_base_url'] = '...' // The base URL for the API
```

## Sending a new request
You can send a new request to the API simply by creating a new instance of `Request`:
```php
$programs = new TamkeenLMSAPI\Request('programs'); // Create the request
$response = $programs->send(); // Returns the API response as an object.
```

## Available requests
### Getting the programs
To fetch the programs list you will need to provide the id of the branch for this program and also the id of the category. You can retrieve these information through other requests avaulable in these docs.

```php
```