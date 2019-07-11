## Seamless HR Test

##Endpoints

+ POST /api/register
```sh
  {"email" : "example@example.com", "password": "123456", "confirm_password": "123456", "name": "John Doe"}
```
+ POST /api/login
```sh
  {"email" : "example@example.com", "password": "123456"}
```
+ POST /courses/register
```sh
  {"course_ids" : [5, 2, 4]}
```

+ GET /courses/create
+ GET /courses/export
+ GET /courses/list