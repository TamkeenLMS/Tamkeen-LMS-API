# About
This is the documentation for the official [Tamkeen LMS](https://tamkeenlms.com) API client. You can use this API client to do a couple of simple operations like retrieving the courses and submitting a new request for one of these courses.

- Tamkeen LMS API is available for you to access through HTTP, this means that you can call it via any cURL library using any courseming language.
- You MUST pass the API key with EVERY request. This key will be given to you by the Tamkeen team. But notice that this key can and will be changed from time to time, specially with new updates.
- The response will always be in JSON format.
- The API has a throttling limit of 1000 requests per minite. After that you will need to wait for a full minute before being able to submit another request. The response in this case will be "Too Many Attempts.", and the status code will be 429.
- With any request you send you can ask for a specific language locale for the response. The available locales right now are "en" and "ar". This will be usefull whenever the response carries text, like with the validation messages. You can set the locale for each request by passing "locale=[locale]" in the URL's query string. Example: `POST api/v1/courses/signup?locale=ar`.
- Most of the requests require you to specify the branch on which the request should be performed. Like when asking the API for the courses list, you MUST specify the `id` of the branch from which you need to get the courses in the request. This is done by passing the branch's `id` in the url query string. Example: Example: `GET api/v1/courses?branch=1`.
- You can get yourself familiar with the API by simply requesting the API's URLs in the browser or via tools like [Postman](https://www.getpostman.com/).


# Installation
You can install this library using Composer:
```
composer require tamkeenlms/tamkeelms-api
```

Now, in your code you will need to initiate the API by setting up the basic request information i.e the API key and the base URI for the API.
```php
TamkeenLMSAPI\Client::setup([API base uri], [API key]);

//Example:
TamkeenLMSAPI\Client::setup('https://company.com/app/public/api/v1/', 'UOYfo9YLk4NTjhx6yyVG0rDDkCt2aFCOeCwtbZfUAdeu8f');
```
The base uri should be the full path to the API uri, for example: https://example.com/app/public/api/v1/. 
The API key will be given to you by the copy owner or by Tamkeen LMS team.



# Requests

### Getting the company's list of branches
Tamkeen supports working with multiple branches (locations of the same company or organization), each branch has its own courses, courses, lectures ... etc, and of course its own list of website courses. So you will need to represent this on your application and separate between the data from each branch. This request returns a list of the branches added on the system, each with the id and the name. You will need to use this request to fetch a list of the branches so that the user could pick from when for exampling signing up for a course.

Example:
```php
$request = new TamkeenLMSAPI\Requests\Branches();
$response = $request->get();
```

Example response:
```json
{
   "branches":[
      {
         "id":1,
         "name":"Branch 1"
      },
      {
         "id":2,
         "name":"Branch 2"
      }
   ]
}
```


### Getting the courses
First you need to understand that we have two different data models here; a `Course` and a `Website Progam`. A course is the training course registered on the system, and a `Website Course` is the model which encapsulates the Course and carries its properties on the website, that IF it was SELECTED to be shown on the website! So, the returned list will hold both the Course and the Website Course, the first being passed within the later one as shown below in the sample request.

Tamkeen LMS supports multi branches, so each course is added to the application is added __under__ a branch, also the courses are grouped by categories. So, when fetching any group of courses you will need to pass ids of both the branch and the category. As for the the ids for the branch and the category you can retrieve them through other requests mentioned below.

```php
$request = new TamkeenLMSAPI\Requests\Courses\Courses([branch id], [category id]);
$response = $request->get();
```

The response returned will look like this:
```json
{
   "courses":{
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
            "course_id":1,
            "category_id":1,
            "about":"HTML information about this course ....",
            "course":{
               "id":1,
               "name":"Course 1 name",
               "cost":"300.00",
               "cost_basis":"lecture"
            }
         },
         {
            "id":3,
            "course_id":2,
            "category_id":1,
            "about":null,
            "course":{
               "id":2,
               "name":"Course 2 name",
               "cost":"5000.00",
               "cost_basis":"trainee"
            }
         }
      ]
   }
}

```
As you can see, the response returned accounts for pagination, which means you can simply paginate through the courses simply by passing the page's number in the uri. Example: `GET courses?branch=1&category=1&page=2` This request will return the page 2 of the full list. Each page has 20 courses.
```php
$request = new TamkeenLMSAPI\Requests\Courses\Courses([branch id], [category id]);
$request->setPage([page numver]); // The page number
```

### Getting the courses categories
The courses are categorized on Tamkeen LMS end, and when retrieving a list of the courses you will need to specify the category for the targeted courses, by id. Here is how to fetch the full list of these categories:

```php
$request = new TamkeenLMSAPI\Requests\Courses\Categories([branch id]);
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

### Submitting a course request (sign up)
Through your application and using our API you can list and view the courses stored on Tamkeen LMS's database, but also you can submit a course request (made by one of your app's users) to be stored and viewed on our end. You will be responsible for building the form and validating the user's input, and then submit it to us. Of course you will need to attach the id of the course (which the user requested, and which represents the `Website course`, not the `Course` itself) along with the request.

The data you can ask for in your form is: the course (=course_id), name (=name), phone number (=phone_number), email (=email), the job title (=job_title), note (=note). Of course only the course_id, name, and phone_number values are required. You don't need to submit the id of the branch here because we can find it based on the course you selected.

The user when submitted will be added to a temporary list on under the specified website course, and after filtering can be added to the course's actual waiting list on the application.

Example:
```php
$request = new TamkeenLMSAPI\Requests\Courses\Signup([
	'course_id' => $_POST['course_id'],
	'name' => $_POST['name'],
	'phone_number' => $_POST['phone_number'],
	'email' => $_POST['email'],
	'job_title' => $_POST['job_title'],
	'note' => $_POST['note'],
]);

// Submit the sign up  request
$response = $request->submit();
```

The information you will send via the API will pass a strict validation rules, and if the validation fails an error will be returned with the validation messages. Example:
```json
{
   "error":"invalid_input",
   "messages":[
      "The name field is required."
   ]
}
```
You can display these error messages for the user so that he could check his/her input for the returned errors.

If the signup process was successfull the API will return:
```json
{
   "message":"success"
}
```
Or the following on failure:
```json
{
   "message":"failed"
}
```

# Help
We are more than willing to help you with Tamkeen LMS API, please contact us anytime with any questions you have at contact@tamkeenlms.com, or simply open a new issue here at this repo for code issues, bugs and feature requests.

Thanks, and good luck.

Tamkeen LMS Team

[tamkeenlms.com](https://tamkeenlms.com)
