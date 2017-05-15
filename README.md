# Log file viewer API

RESRFul Web Service for get log file content under server log directory.

## Getting started

```
$ git clone git@github.com:piranon/log-file-viewer-api.git
$ cd log-file-viewer-api
$ composer install
```

## Running Dev Server

```
$ cd log-file-viewer-api
$ cd docker
$ docker-composer up --build -d
```

and access dev server via localhost:8081

## Running the tests

```
$ ./vendor/bin/codecept run
```

## Request & Response Examples

### API Resources

- GET /files/[path-to-log-file]
- GET /files/[path-to-log-file]/?lines=10,20

### GET /files/[path-to-log-file]

Example: http://api.logfileviewer.tk/files/var/tmp/access_log.1

Response body:

    {
        "data": [
            {
                "line": 1,
                "text": "content 1"
            },
            ....
            {
                "line": 10,
                "text": "content 10",
            }
        ],
        "total_count": 123
    }

### GET /files/[path-to-log-file]/?lines=10,20

Example: http://api.logfileviewer.tk/files/var/tmp/access_log.1/?lines=7,9

Response body:

    {
        "data": [
            {
                "line": 7,
                "text": "content 7"
            },
            {
                "line": 8,
                "text": "content 8",
            },
            {
                "line": 9,
                "text": "content 9",
            }
        ],
        "total_count": 123
    }

## Error handling

Error responses will include a common HTTP status code and message for the end-user

    {
        "error" : {
            "code": 404,
            "message": "File not found."
        }
    }
