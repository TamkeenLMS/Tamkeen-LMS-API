# About
This is the documentation for the official [Tamkeen LMS](tamkeenlms.com) API client. 
You can use this API client to do a couple of simple operations like retreiving the programs and submiting a new signup request.

# Installation
You can install this library using Composer:
```
composer require tamkeenlms/api
```

Now, in your code you will need to intiate the API by setting up the basic request information ie. the API key and the base URI for the API.
```php
TamkeenLMSAPI\Client::setup([API base uri], [API key]);
```
The base uri should be the full path to the API uri, for example: https://example.com/app/public/api/v1/. 
The API key will be given to you by the copy owner or by Tamkeen LMS team.



# Requests
### Getting the programs
To fetch the programs list you will need to provide the id of the branch for this program and also the id of the category. 
This request supportes pagination, and the response will carry all the data needed for you to paginate the programs on your application.

```php
	$request = new TamkeenLMSAPI\Requests\Programs\Programs([branch id], [category id]);
	$response = $request->get();
```
As for the the ids for the branch and the category you can retreive them through other requestes detailed below.

You can set the page number (for pagination) like so:
```php
	$request = new TamkeenLMSAPI\Requests\Programs\Programs([branch id], [category id]);
	$request->setPage([page numver]);
```

The response returned will look like this:
```json
{
   "programs":{
      "total":2,
      "per_page":20,
      "current_page":1,
      "last_page":1,
      "next_page_url":null,
      "prev_page_url":null,
      "from":1,
      "to":2,
      "data":[
         {
            "id":1,
            "program_id":1,
            "category_id":1,
            "about":null,
            "program":{
               "id":1,
               "name":"Program 1 name",
               "cost":"300.00",
               "cost_basis":"lecture"
            }
         },
         {
            "id":3,
            "program_id":2,
            "category_id":1,
            "about":null,
            "program":{
               "id":2,
               "name":"Program 2 name",
               "cost":"5000.00",
               "cost_basis":"trainee"
            }
         }
      ]
   }
}

```

### Getting the programs categories
The programs are categoriezed on Tamkeen LMS' end, and when retreiving a list of the programs you will need to specify the category for the targeted programs, by id.
Here is how to fetch the full list of these categories:

```php
	$request = new TamkeenLMSAPI\Requests\Programs\Categories([branch id]);
	$response = $request->get();
```

Example response:
```json
{
   "categories":[
      {
         "id":1,
         "name":"Test Category",
         "description":"Category description"
      },
      {
         "id":2,
         "name":"Category 2",
         "description":"Category 2 description"
      }
   ]
}
```