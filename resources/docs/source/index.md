---
title: API Reference

language_tabs:

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost:8002/docs/collection.json)

<!-- END_INFO -->

#Activity management


<!-- START_95d2e24a602465170307b4b9a18ae6da -->
## Display a listing of courses resources.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "links": {
            "href": "\/api\/v2\/activities",
            "title": "Actividades disponibles desde Moodle",
            "rel": "self"
        },
        "numberOfElements": 2,
        "collections": [
            {
                "links": {
                    "href": "\/api\/v2\/activities\/3",
                    "rel": "self"
                },
                "properties": {
                    "id": 3,
                    "description": "Tarea: Unidad 2.1",
                    "type": "Tareas",
                    "weighing": 10,
                    "idActivityMoodle": 631096,
                    "createdAt": "27-04-2020",
                    "updatedAt": "27-04-2020"
                },
                "nestedObjects": {
                    "course": {
                        "links": {
                            "url": "http:\/\/localhost:8002\/api\/v2\/courses\/2",
                            "href": "\/api\/v2\/courses\/2",
                            "rel": "self"
                        },
                        "properties": {
                            "id": 2,
                            "description": "Curso: Estrategias didáctica de la Enseñanza Media Técnico Profesional",
                            "idCourseMoodle": 9135,
                            "status": 1,
                            "createdAt": "27-04-2020",
                            "updatedAt": "27-04-2020"
                        }
                    }
                },
                "relationships": {
                    "activityCourseUser": {
                        "numberOfElements": 383,
                        "links": {
                            "href": "\/api\/v2\/activities\/3\/activity-course-users",
                            "rel": "\/rels\/activityCourseUser"
                        }
                    }
                }
            },
            {
                "links": {
                    "href": "\/api\/v2\/activities\/3",
                    "rel": "self"
                },
                "properties": {
                    "id": 3,
                    "description": "Tarea: Unidad 2.1",
                    "type": "Tareas",
                    "weighing": 10,
                    "idActivityMoodle": 631096,
                    "createdAt": "27-04-2020",
                    "updatedAt": "27-04-2020"
                },
                "nestedObjects": {
                    "course": {
                        "links": {
                            "url": "http:\/\/localhost:8002\/api\/v2\/courses\/2",
                            "href": "\/api\/v2\/courses\/2",
                            "rel": "self"
                        },
                        "properties": {
                            "id": 2,
                            "description": "Curso: Estrategias didáctica de la Enseñanza Media Técnico Profesional",
                            "idCourseMoodle": 9135,
                            "status": 1,
                            "createdAt": "27-04-2020",
                            "updatedAt": "27-04-2020"
                        }
                    }
                },
                "relationships": {
                    "activityCourseUser": {
                        "numberOfElements": 383,
                        "links": {
                            "href": "\/api\/v2\/activities\/3\/activity-course-users",
                            "rel": "\/rels\/activityCourseUser"
                        }
                    }
                }
            }
        ]
    }
}
```

### HTTP Request
`GET api/v2/activities`


<!-- END_95d2e24a602465170307b4b9a18ae6da -->

<!-- START_5031520e66564b6d4ef65585d3d3551f -->
## Display the specified resource.

> Example request:



### HTTP Request
`GET api/v2/activities/{activity}`


<!-- END_5031520e66564b6d4ef65585d3d3551f -->

<!-- START_4fa1b6b9495a9918d140622c9561ae10 -->
## Remove the specified resource from storage.

> Example request:



### HTTP Request
`DELETE api/v2/activities/{activity}`


<!-- END_4fa1b6b9495a9918d140622c9561ae10 -->

<!-- START_b15051f09964060c2749b7d8fd8b3239 -->
## api/v2/activities/{activity}/activity-course-users
> Example request:



### HTTP Request
`GET api/v2/activities/{activity}/activity-course-users`


<!-- END_b15051f09964060c2749b7d8fd8b3239 -->

#Category management


<!-- START_94d07e72ebb9866562ac55dedcf3994d -->
## Display a listing of categories resources.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "links": {
            "href": "\/api\/v2\/categories",
            "title": "Categorías disponibles desde Moodle",
            "rel": "self"
        },
        "numberOfElements": 2,
        "collections": [
            {
                "links": {
                    "href": "\/api\/v2\/categories\/1",
                    "rel": "self"
                },
                "properties": {
                    "id": 1,
                    "description": "Estrategias didáctica TP (2020)",
                    "idCategoryMoodle": 953,
                    "status": 1,
                    "createdAt": "27-04-2020",
                    "updatedAt": "27-04-2020"
                },
                "nestedObjects": {
                    "platform": {
                        "links": {
                            "href": "\/api\/v2\/platforms\/1",
                            "rel": "self"
                        },
                        "properties": {
                            "id": 1,
                            "description": "eMineduc",
                            "status": 1,
                            "createdAt": "27-04-2020",
                            "updatedAt": "27-04-2020"
                        }
                    }
                },
                "relationships": {
                    "numberOfElements": 2,
                    "links": {
                        "href": "\/api\/v2\/categories\/1\/courses",
                        "rel": "\/rels\/courses"
                    }
                }
            },
            {
                "links": {
                    "href": "\/api\/v2\/categories\/1",
                    "rel": "self"
                },
                "properties": {
                    "id": 1,
                    "description": "Estrategias didáctica TP (2020)",
                    "idCategoryMoodle": 953,
                    "status": 1,
                    "createdAt": "27-04-2020",
                    "updatedAt": "27-04-2020"
                },
                "nestedObjects": {
                    "platform": {
                        "links": {
                            "href": "\/api\/v2\/platforms\/1",
                            "rel": "self"
                        },
                        "properties": {
                            "id": 1,
                            "description": "eMineduc",
                            "status": 1,
                            "createdAt": "27-04-2020",
                            "updatedAt": "27-04-2020"
                        }
                    }
                },
                "relationships": {
                    "numberOfElements": 2,
                    "links": {
                        "href": "\/api\/v2\/categories\/1\/courses",
                        "rel": "\/rels\/courses"
                    }
                }
            }
        ]
    }
}
```

### HTTP Request
`GET api/v2/categories`


<!-- END_94d07e72ebb9866562ac55dedcf3994d -->

<!-- START_34cff46a3c56ad904f624d8e5ffb2c39 -->
## Display the category resource.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "links": {
                "href": "\/api\/v2\/categories\/1",
                "rel": "self"
            },
            "properties": {
                "id": 1,
                "description": "Estrategias didáctica TP (2020)",
                "idCategoryMoodle": 953,
                "status": 1,
                "createdAt": "27-04-2020",
                "updatedAt": "27-04-2020"
            }
        },
        {
            "links": {
                "href": "\/api\/v2\/categories\/1",
                "rel": "self"
            },
            "properties": {
                "id": 1,
                "description": "Estrategias didáctica TP (2020)",
                "idCategoryMoodle": 953,
                "status": 1,
                "createdAt": "27-04-2020",
                "updatedAt": "27-04-2020"
            }
        }
    ]
}
```

### HTTP Request
`GET api/v2/categories/{category}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `category` |  required  | The ID of the category resource.

<!-- END_34cff46a3c56ad904f624d8e5ffb2c39 -->

<!-- START_48c461c31bbd959a9d53f9f1a44a2b8c -->
## Display a list of courses resources related to category resource.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "category": "category",
    "relationships": {
        "links": {
            "href": "url",
            "rel": "\/rels\/courses"
        },
        "collections": {
            "numberOfElements": "number",
            "data": "array"
        }
    }
}
```

### HTTP Request
`GET api/v2/categories/{category}/courses`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `category` |  required  | The ID of the category resource.

<!-- END_48c461c31bbd959a9d53f9f1a44a2b8c -->

#Course management


<!-- START_6aef3c403afb1eafcfdd51b7136e1998 -->
## Display a listing of courses resources.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "links": {
            "href": "\/api\/v2\/courses",
            "title": "Cursos disponibles desde Moodle",
            "rel": "self"
        },
        "numberOfElements": 2,
        "collections": [
            {
                "links": {
                    "href": "\/api\/v2\/courses\/1",
                    "rel": "self"
                },
                "properties": {
                    "id": 1,
                    "description": "Curso: Estrategias didáctica de la Enseñanza Media Técnico Profesional (Plantilla)",
                    "idCategoryMoodle": null,
                    "status": 0,
                    "createdAt": "27-04-2020",
                    "updatedAt": "27-04-2020"
                },
                "nestedObjects": {
                    "category": {
                        "links": {
                            "href": "\/api\/v2\/categories\/1",
                            "rel": "self"
                        },
                        "properties": {
                            "id": 1,
                            "description": "Estrategias didáctica TP (2020)",
                            "idCategoryMoodle": 953,
                            "status": 1,
                            "createdAt": "27-04-2020",
                            "updatedAt": "27-04-2020"
                        }
                    }
                },
                "relationships": {
                    "activities": {
                        "numberOfElements": 0,
                        "links": {
                            "href": "\/api\/v2\/courses\/1\/activities",
                            "rel": "\/rels\/activities"
                        }
                    },
                    "registeredUsers": {
                        "numberOfElements": 0,
                        "links": {
                            "href": "\/api\/v2\/courses\/1\/registered-users",
                            "rel": "\/rels\/registeredUsers"
                        }
                    }
                }
            },
            {
                "links": {
                    "href": "\/api\/v2\/courses\/1",
                    "rel": "self"
                },
                "properties": {
                    "id": 1,
                    "description": "Curso: Estrategias didáctica de la Enseñanza Media Técnico Profesional (Plantilla)",
                    "idCategoryMoodle": null,
                    "status": 0,
                    "createdAt": "27-04-2020",
                    "updatedAt": "27-04-2020"
                },
                "nestedObjects": {
                    "category": {
                        "links": {
                            "href": "\/api\/v2\/categories\/1",
                            "rel": "self"
                        },
                        "properties": {
                            "id": 1,
                            "description": "Estrategias didáctica TP (2020)",
                            "idCategoryMoodle": 953,
                            "status": 1,
                            "createdAt": "27-04-2020",
                            "updatedAt": "27-04-2020"
                        }
                    }
                },
                "relationships": {
                    "activities": {
                        "numberOfElements": 0,
                        "links": {
                            "href": "\/api\/v2\/courses\/1\/activities",
                            "rel": "\/rels\/activities"
                        }
                    },
                    "registeredUsers": {
                        "numberOfElements": 0,
                        "links": {
                            "href": "\/api\/v2\/courses\/1\/registered-users",
                            "rel": "\/rels\/registeredUsers"
                        }
                    }
                }
            }
        ]
    }
}
```

### HTTP Request
`GET api/v2/courses`


<!-- END_6aef3c403afb1eafcfdd51b7136e1998 -->

<!-- START_9cae39f7fccfcdc203368f2df17d7f90 -->
## Display the course resource.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "links": {
                "url": "http:\/\/localhost:8002\/api\/v2\/courses\/1",
                "href": "\/api\/v2\/courses\/1",
                "rel": "self"
            },
            "properties": {
                "id": 1,
                "description": "Curso: Estrategias didáctica de la Enseñanza Media Técnico Profesional (Plantilla)",
                "idCourseMoodle": 8970,
                "status": 0,
                "createdAt": "27-04-2020",
                "updatedAt": "27-04-2020"
            }
        },
        {
            "links": {
                "url": "http:\/\/localhost:8002\/api\/v2\/courses\/1",
                "href": "\/api\/v2\/courses\/1",
                "rel": "self"
            },
            "properties": {
                "id": 1,
                "description": "Curso: Estrategias didáctica de la Enseñanza Media Técnico Profesional (Plantilla)",
                "idCourseMoodle": 8970,
                "status": 0,
                "createdAt": "27-04-2020",
                "updatedAt": "27-04-2020"
            }
        }
    ]
}
```

### HTTP Request
`GET api/v2/courses/{course}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `course` |  required  | The ID of the course resource.

<!-- END_9cae39f7fccfcdc203368f2df17d7f90 -->

<!-- START_1a90c202772a13ec11f64fefc2c9f686 -->
## Display a list of activities resources related to course resource.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "course": "course",
    "relationships": {
        "links": {
            "href": "url",
            "rel": "\/rels\/activities"
        },
        "collections": {
            "numberOfElements": "number",
            "data": "array"
        }
    }
}
```

### HTTP Request
`GET api/v2/courses/{course}/activities`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `course` |  required  | The ID of the course resource.

<!-- END_1a90c202772a13ec11f64fefc2c9f686 -->

<!-- START_b567ab6792156a05b47237e3305891db -->
## Display a list of registered users resources related to course resource.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "registeredUser": "registeredUser",
    "relationships": {
        "links": {
            "href": "url",
            "rel": "\/rels\/registeredUsers"
        },
        "collections": {
            "numberOfElements": "number",
            "data": "array"
        }
    }
}
```

### HTTP Request
`GET api/v2/courses/{course}/registered-users`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `course` |  required  | The ID of the course resource.

<!-- END_b567ab6792156a05b47237e3305891db -->

<!-- START_64cdd93694bf7d08118e7bef1448b7f0 -->
## Display the specific registered user resource related to course resource.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "courseRegisteredUser": "courseRegisteredUser",
    "course": "course",
    "relationships": {
        "collections": {
            "numberOfElements": "number",
            "links": {
                "href": "url",
                "rel": "\/rels\/activities"
            }
        }
    }
}
```

### HTTP Request
`GET api/v2/courses/{course}/registered-users/{registered_user}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `course` |  required  | The ID of the course resource.
    `registered_user` |  required  | The ID of the registered user resource.

<!-- END_64cdd93694bf7d08118e7bef1448b7f0 -->

<!-- START_71f0ae5d034033482e3c78abc4309118 -->
## Display a list of activities resources related to Course for the specific user resource.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "courseRegisteredUser": "courseRegisteredUser",
    "relationships": {
        "links": {
            "href": "url",
            "rel": "\/rels\/activities"
        },
        "collections": {
            "numberOfElements": "number",
            "data": "array"
        }
    }
}
```

### HTTP Request
`GET api/v2/courses/{course}/registered-users/{registered_user}/activities`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `course` |  required  | The ID of the course resource.
    `registered_user` |  required  | The ID of the registered user resource.

<!-- END_71f0ae5d034033482e3c78abc4309118 -->

#Platform management


<!-- START_9f24b60bae02f95478d704bb25231992 -->
## Display a listing of platforms resources.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "links": {
            "href": "\/api\/v2\/platforms",
            "title": "Plataformas disponibles desde Moodle",
            "rel": "self"
        },
        "numberOfElements": 2,
        "collections": [
            {
                "links": {
                    "href": "\/api\/v2\/platforms\/1",
                    "rel": "self"
                },
                "properties": {
                    "id": 1,
                    "description": "eMineduc",
                    "status": 1,
                    "createdAt": "27-04-2020",
                    "updatedAt": "27-04-2020"
                },
                "nestedObjects": null,
                "relationships": {
                    "numberOfElements": 3,
                    "links": {
                        "href": "\/api\/v2\/platforms\/1\/categories",
                        "rel": "\/rels\/categories"
                    }
                }
            },
            {
                "links": {
                    "href": "\/api\/v2\/platforms\/1",
                    "rel": "self"
                },
                "properties": {
                    "id": 1,
                    "description": "eMineduc",
                    "status": 1,
                    "createdAt": "27-04-2020",
                    "updatedAt": "27-04-2020"
                },
                "nestedObjects": null,
                "relationships": {
                    "numberOfElements": 3,
                    "links": {
                        "href": "\/api\/v2\/platforms\/1\/categories",
                        "rel": "\/rels\/categories"
                    }
                }
            }
        ]
    }
}
```

### HTTP Request
`GET api/v2/platforms`


<!-- END_9f24b60bae02f95478d704bb25231992 -->

<!-- START_919d5242b4eeaebcef7ee75e66e7d585 -->
## Display the platform resource.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "links": {
                "href": "\/api\/v2\/platforms\/1",
                "rel": "self"
            },
            "properties": {
                "id": 1,
                "description": "eMineduc",
                "status": 1,
                "createdAt": "27-04-2020",
                "updatedAt": "27-04-2020"
            }
        },
        {
            "links": {
                "href": "\/api\/v2\/platforms\/1",
                "rel": "self"
            },
            "properties": {
                "id": 1,
                "description": "eMineduc",
                "status": 1,
                "createdAt": "27-04-2020",
                "updatedAt": "27-04-2020"
            }
        }
    ]
}
```

### HTTP Request
`GET api/v2/platforms/{platform}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `platform` |  required  | The ID of the platform resource.

<!-- END_919d5242b4eeaebcef7ee75e66e7d585 -->

<!-- START_abe9f0711abd831f26874700307ce522 -->
## Display a list of a categories resources related to platform resource.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "platform": "platform",
    "relationships": {
        "links": {
            "href": "url",
            "rel": "\/rels\/categories"
        },
        "collections": {
            "numberOfElements": "number",
            "data": "array"
        }
    }
}
```

### HTTP Request
`GET api/v2/platforms/{platform}/categories`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `platform` |  required  | The ID of the platform resource.

<!-- END_abe9f0711abd831f26874700307ce522 -->

#general


<!-- START_9fd4e9d17f428a3dfb700c83dd25354e -->
## api/upload-file/excel
> Example request:



### HTTP Request
`GET api/upload-file/excel`


<!-- END_9fd4e9d17f428a3dfb700c83dd25354e -->

<!-- START_a925a8d22b3615f12fca79456d286859 -->
## Login user and create token

> Example request:



### HTTP Request
`POST api/auth/login`


<!-- END_a925a8d22b3615f12fca79456d286859 -->

<!-- START_9357c0a600c785fe4f708897facae8b8 -->
## Create user

> Example request:



### HTTP Request
`POST api/auth/signup`


<!-- END_9357c0a600c785fe4f708897facae8b8 -->

<!-- START_ff6d656b6d81a61adda963b8702034d2 -->
## Get the authenticated User

> Example request:



### HTTP Request
`GET api/auth/user`


<!-- END_ff6d656b6d81a61adda963b8702034d2 -->

<!-- START_16928cb8fc6adf2d9bb675d62a2095c5 -->
## Logout user (Revoke the token)

> Example request:



### HTTP Request
`GET api/auth/logout`


<!-- END_16928cb8fc6adf2d9bb675d62a2095c5 -->

<!-- START_e307ec43d60cd5a1125b29ada44f8b79 -->
## Display a listing of the resource.

> Example request:



### HTTP Request
`GET api/v2/type-tickets`


<!-- END_e307ec43d60cd5a1125b29ada44f8b79 -->

<!-- START_e218fd2490c8d3c3ca4e9df52226873a -->
## Store a newly created resource in storage.

> Example request:



### HTTP Request
`POST api/v2/type-tickets`


<!-- END_e218fd2490c8d3c3ca4e9df52226873a -->

<!-- START_ced6b4ed2487d1a010775c6d9382eecb -->
## Display the specified resource.

> Example request:



### HTTP Request
`GET api/v2/type-tickets/{type_ticket}`


<!-- END_ced6b4ed2487d1a010775c6d9382eecb -->

<!-- START_134e6104352625461c26b6982c46a55a -->
## Update the specified resource in storage.

> Example request:



### HTTP Request
`PUT api/v2/type-tickets/{type_ticket}`

`PATCH api/v2/type-tickets/{type_ticket}`


<!-- END_134e6104352625461c26b6982c46a55a -->

<!-- START_69f5a4f9642c39219ff5d452cb9037d0 -->
## Remove the specified resource from storage.

> Example request:



### HTTP Request
`DELETE api/v2/type-tickets/{type_ticket}`


<!-- END_69f5a4f9642c39219ff5d452cb9037d0 -->

<!-- START_191ae651323ecb4e160c0629af473219 -->
## Display a listing of the resource.

> Example request:



### HTTP Request
`GET api/v2/alerts`


<!-- END_191ae651323ecb4e160c0629af473219 -->

<!-- START_4f6163055597f2528fb34328adc85bda -->
## Store a newly created resource in storage.

> Example request:



### HTTP Request
`POST api/v2/alerts`


<!-- END_4f6163055597f2528fb34328adc85bda -->

<!-- START_69e03db5153a4c986c336a59c23699b9 -->
## Display the specified resource.

> Example request:



### HTTP Request
`GET api/v2/alerts/{alert}`


<!-- END_69e03db5153a4c986c336a59c23699b9 -->

<!-- START_837fbbebfd0d7cacb219053d449c310f -->
## Update the specified resource in storage.

> Example request:



### HTTP Request
`PUT api/v2/alerts/{alert}`

`PATCH api/v2/alerts/{alert}`


<!-- END_837fbbebfd0d7cacb219053d449c310f -->

<!-- START_93a5f02287248f6585ad332675bf391a -->
## Remove the specified resource from storage.

> Example request:



### HTTP Request
`DELETE api/v2/alerts/{alert}`


<!-- END_93a5f02287248f6585ad332675bf391a -->

<!-- START_17f4254a84e218331d6388f5f6cffb19 -->
## Display a listing of the resource.

> Example request:



### HTTP Request
`GET api/v2/tickets`


<!-- END_17f4254a84e218331d6388f5f6cffb19 -->

<!-- START_554a086fedab41b01a9102fca3163787 -->
## Store a newly created resource in storage.

> Example request:



### HTTP Request
`POST api/v2/tickets`


<!-- END_554a086fedab41b01a9102fca3163787 -->

<!-- START_035f6e17bed7924106317e8473f43c7a -->
## Display the specified resource.

> Example request:



### HTTP Request
`GET api/v2/tickets/{ticket}`


<!-- END_035f6e17bed7924106317e8473f43c7a -->

<!-- START_e601c0f6b4ce47b48a9a206018961208 -->
## Update the specified resource in storage.

> Example request:



### HTTP Request
`PUT api/v2/tickets/{ticket}`

`PATCH api/v2/tickets/{ticket}`


<!-- END_e601c0f6b4ce47b48a9a206018961208 -->

<!-- START_933f7b9360ea9431807eebb06aeb8d63 -->
## Remove the specified resource from storage.

> Example request:



### HTTP Request
`DELETE api/v2/tickets/{ticket}`


<!-- END_933f7b9360ea9431807eebb06aeb8d63 -->

<!-- START_0edae1b9832f6c5a9d52cef0f08dc33a -->
## Display a listing of the resource.

> Example request:



### HTTP Request
`GET api/v2/activity-course-users`


<!-- END_0edae1b9832f6c5a9d52cef0f08dc33a -->

<!-- START_5ba21f95a8fd3fec22aec475589296c6 -->
## api/v2/activity-course-users
> Example request:



### HTTP Request
`POST api/v2/activity-course-users`


<!-- END_5ba21f95a8fd3fec22aec475589296c6 -->

<!-- START_4f18968847e2013832047fdd284f3c7e -->
## Display the specified resource.

> Example request:



### HTTP Request
`GET api/v2/activity-course-users/{activity_course_user}`


<!-- END_4f18968847e2013832047fdd284f3c7e -->

<!-- START_b5d854389c1eedfbb68852747169f9d0 -->
## api/v2/activity-course-users/{activity_course_user}
> Example request:



### HTTP Request
`PUT api/v2/activity-course-users/{activity_course_user}`

`PATCH api/v2/activity-course-users/{activity_course_user}`


<!-- END_b5d854389c1eedfbb68852747169f9d0 -->

<!-- START_3889fd66846e839eddc0ff92d8c16365 -->
## Remove the specified resource from storage.

> Example request:



### HTTP Request
`DELETE api/v2/activity-course-users/{activity_course_user}`


<!-- END_3889fd66846e839eddc0ff92d8c16365 -->

<!-- START_6cf64cf7fa84d514549a5481d7f8f304 -->
## Display a listing of the resource.

> Example request:



### HTTP Request
`GET api/v2/course-registered-users`


<!-- END_6cf64cf7fa84d514549a5481d7f8f304 -->

<!-- START_4815f9908553a23d04ab4205a1514f5f -->
## Store a newly created resource in storage.

> Example request:



### HTTP Request
`POST api/v2/course-registered-users`


<!-- END_4815f9908553a23d04ab4205a1514f5f -->

<!-- START_dfcae8b7a284e5947f4698ee8979e568 -->
## Display the specified resource.

> Example request:



### HTTP Request
`GET api/v2/course-registered-users/{course_registered_user}`


<!-- END_dfcae8b7a284e5947f4698ee8979e568 -->

<!-- START_fd0466fb9e94c2f30551a07a15c78ae6 -->
## api/v2/course-registered-users/{course_registered_user}
> Example request:



### HTTP Request
`PUT api/v2/course-registered-users/{course_registered_user}`

`PATCH api/v2/course-registered-users/{course_registered_user}`


<!-- END_fd0466fb9e94c2f30551a07a15c78ae6 -->

<!-- START_bfecf37a6628b1eb06ffafac8ed83c44 -->
## Remove the specified resource from storage.

> Example request:



### HTTP Request
`DELETE api/v2/course-registered-users/{course_registered_user}`


<!-- END_bfecf37a6628b1eb06ffafac8ed83c44 -->

<!-- START_0ede783a676f6e7e702bde5114b9c8fd -->
## Display a listing of the resource.

> Example request:



### HTTP Request
`GET api/v2/registered-users`


<!-- END_0ede783a676f6e7e702bde5114b9c8fd -->

<!-- START_b1d5ee47a563f00ebbf3942d7071a553 -->
## Store a newly created resource in storage.

> Example request:



### HTTP Request
`POST api/v2/registered-users`


<!-- END_b1d5ee47a563f00ebbf3942d7071a553 -->

<!-- START_a7887e90f3b924125d4c92e4eb4bdef8 -->
## Display the specified resource.

> Example request:



### HTTP Request
`GET api/v2/registered-users/{registered_user}`


<!-- END_a7887e90f3b924125d4c92e4eb4bdef8 -->

<!-- START_820ed65ab86a08b91caae3de3980f2d2 -->
## Update the specified resource in storage.

> Example request:



### HTTP Request
`PUT api/v2/registered-users/{registered_user}`

`PATCH api/v2/registered-users/{registered_user}`


<!-- END_820ed65ab86a08b91caae3de3980f2d2 -->

<!-- START_9f72874d25885ea62d70ce6a77089f1e -->
## Remove the specified resource from storage.

> Example request:



### HTTP Request
`DELETE api/v2/registered-users/{registered_user}`


<!-- END_9f72874d25885ea62d70ce6a77089f1e -->

<!-- START_594ae13f859f88d3dadf5a248d780689 -->
## Display a listing of the resource.

> Example request:



### HTTP Request
`GET api/v2/status-ticket`


<!-- END_594ae13f859f88d3dadf5a248d780689 -->

<!-- START_21be7fffa9da902d5ee86451f3973788 -->
## Store a newly created resource in storage.

> Example request:



### HTTP Request
`POST api/v2/status-ticket`


<!-- END_21be7fffa9da902d5ee86451f3973788 -->

<!-- START_3e72dfc9d692b9b6a3d7ca0872936cc0 -->
## Display the specified resource.

> Example request:



### HTTP Request
`GET api/v2/status-ticket/{status_ticket}`


<!-- END_3e72dfc9d692b9b6a3d7ca0872936cc0 -->

<!-- START_8ab6687c2dcff7e723dd3372e1da25cb -->
## Update the specified resource in storage.

> Example request:



### HTTP Request
`PUT api/v2/status-ticket/{status_ticket}`

`PATCH api/v2/status-ticket/{status_ticket}`


<!-- END_8ab6687c2dcff7e723dd3372e1da25cb -->

<!-- START_e52d546fee9a551af9de810053cbb766 -->
## Remove the specified resource from storage.

> Example request:



### HTTP Request
`DELETE api/v2/status-ticket/{status_ticket}`


<!-- END_e52d546fee9a551af9de810053cbb766 -->

<!-- START_1cd3e104c9d8dae6ddd0c8d914445ed0 -->
## api/v2/registered-user/{rut}
> Example request:



### HTTP Request
`GET api/v2/registered-user/{rut}`


<!-- END_1cd3e104c9d8dae6ddd0c8d914445ed0 -->

<!-- START_39b1eedf2c9371282c1aadf223bddecd -->
## api/v2/activity-course-registered-user/{id}
> Example request:



### HTTP Request
`GET api/v2/activity-course-registered-user/{id}`


<!-- END_39b1eedf2c9371282c1aadf223bddecd -->

<!-- START_bf9f8ba67e81ec80180d58efef9a4af3 -->
## api/v2/type-tickets/{type_ticket}/tickets
> Example request:



### HTTP Request
`GET api/v2/type-tickets/{type_ticket}/tickets`


<!-- END_bf9f8ba67e81ec80180d58efef9a4af3 -->

<!-- START_56af8b0e7f974bae5560f64ff636f82b -->
## api/v2/registered-users/{registered_user}/courses
> Example request:



### HTTP Request
`GET api/v2/registered-users/{registered_user}/courses`


<!-- END_56af8b0e7f974bae5560f64ff636f82b -->

<!-- START_fae76ee6c5e8d1ba4bc912466a3459db -->
## api/v2/registered-users/{registered_user}/courses/{course}
> Example request:



### HTTP Request
`GET api/v2/registered-users/{registered_user}/courses/{course}`


<!-- END_fae76ee6c5e8d1ba4bc912466a3459db -->

<!-- START_1a598bfce9100fc00262e199ef5c21a2 -->
## api/v2/registered-users/{registered_user}/courses/{course}/activities
> Example request:



### HTTP Request
`GET api/v2/registered-users/{registered_user}/courses/{course}/activities`


<!-- END_1a598bfce9100fc00262e199ef5c21a2 -->

<!-- START_d93ff5af2970e7c0d0f47db6d46dfccd -->
## api/v2/registered-users/{registered_user}/tickets
> Example request:



### HTTP Request
`GET api/v2/registered-users/{registered_user}/tickets`


<!-- END_d93ff5af2970e7c0d0f47db6d46dfccd -->


