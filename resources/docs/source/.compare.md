---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://127.0.0.1/docs/collection.json)

<!-- END_INFO -->

#general


<!-- START_0c068b4037fb2e47e71bd44bd36e3e2a -->
## Authorize a client to access the user&#039;s account.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/oauth/authorize" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/authorize"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET oauth/authorize`


<!-- END_0c068b4037fb2e47e71bd44bd36e3e2a -->

<!-- START_e48cc6a0b45dd21b7076ab2c03908687 -->
## Approve the authorization request.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/oauth/authorize" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/authorize"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST oauth/authorize`


<!-- END_e48cc6a0b45dd21b7076ab2c03908687 -->

<!-- START_de5d7581ef1275fce2a229b6b6eaad9c -->
## Deny the authorization request.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/oauth/authorize" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/authorize"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE oauth/authorize`


<!-- END_de5d7581ef1275fce2a229b6b6eaad9c -->

<!-- START_a09d20357336aa979ecd8e3972ac9168 -->
## Authorize a client to access the user&#039;s account.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/oauth/token" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/token"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST oauth/token`


<!-- END_a09d20357336aa979ecd8e3972ac9168 -->

<!-- START_d6a56149547e03307199e39e03e12d1c -->
## Get all of the authorized tokens for the authenticated user.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/oauth/tokens" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/tokens"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET oauth/tokens`


<!-- END_d6a56149547e03307199e39e03e12d1c -->

<!-- START_a9a802c25737cca5324125e5f60b72a5 -->
## Delete the given token.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/oauth/tokens/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/tokens/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE oauth/tokens/{token_id}`


<!-- END_a9a802c25737cca5324125e5f60b72a5 -->

<!-- START_abe905e69f5d002aa7d26f433676d623 -->
## Get a fresh transient token cookie for the authenticated user.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/oauth/token/refresh" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/token/refresh"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST oauth/token/refresh`


<!-- END_abe905e69f5d002aa7d26f433676d623 -->

<!-- START_babcfe12d87b8708f5985e9d39ba8f2c -->
## Get all of the clients for the authenticated user.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/oauth/clients" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/clients"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET oauth/clients`


<!-- END_babcfe12d87b8708f5985e9d39ba8f2c -->

<!-- START_9eabf8d6e4ab449c24c503fcb42fba82 -->
## Store a new client.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/oauth/clients" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/clients"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST oauth/clients`


<!-- END_9eabf8d6e4ab449c24c503fcb42fba82 -->

<!-- START_784aec390a455073fc7464335c1defa1 -->
## Update the given client.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/oauth/clients/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/clients/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT oauth/clients/{client_id}`


<!-- END_784aec390a455073fc7464335c1defa1 -->

<!-- START_1f65a511dd86ba0541d7ba13ca57e364 -->
## Delete the given client.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/oauth/clients/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/clients/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE oauth/clients/{client_id}`


<!-- END_1f65a511dd86ba0541d7ba13ca57e364 -->

<!-- START_9e281bd3a1eb1d9eb63190c8effb607c -->
## Get all of the available scopes for the application.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/oauth/scopes" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/scopes"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET oauth/scopes`


<!-- END_9e281bd3a1eb1d9eb63190c8effb607c -->

<!-- START_9b2a7699ce6214a79e0fd8107f8b1c9e -->
## Get all of the personal access tokens for the authenticated user.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/oauth/personal-access-tokens" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/personal-access-tokens"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET oauth/personal-access-tokens`


<!-- END_9b2a7699ce6214a79e0fd8107f8b1c9e -->

<!-- START_a8dd9c0a5583742e671711f9bb3ee406 -->
## Create a new personal access token for the user.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/oauth/personal-access-tokens" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/personal-access-tokens"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST oauth/personal-access-tokens`


<!-- END_a8dd9c0a5583742e671711f9bb3ee406 -->

<!-- START_bae65df80fd9d72a01439241a9ea20d0 -->
## Delete the given token.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/oauth/personal-access-tokens/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/oauth/personal-access-tokens/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE oauth/personal-access-tokens/{token_id}`


<!-- END_bae65df80fd9d72a01439241a9ea20d0 -->

<!-- START_fb27f6c772459ffafea664f0876cca82 -->
## api/fetch/all
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/fetch/all" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/fetch/all"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "error": null
}
```

### HTTP Request
`GET api/fetch/all`


<!-- END_fb27f6c772459ffafea664f0876cca82 -->

<!-- START_ee8ca9e3c3e39ef8c8997c9789cebfcd -->
## api/fetch/all/platforms-categories
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/fetch/all/platforms-categories" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/fetch/all/platforms-categories"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "error": null
}
```

### HTTP Request
`GET api/fetch/all/platforms-categories`


<!-- END_ee8ca9e3c3e39ef8c8997c9789cebfcd -->

<!-- START_e48b66d39d5203dceb63e5cf3a713bb9 -->
## api/fetch/all/courses
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/fetch/all/courses" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/fetch/all/courses"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "error": null
}
```

### HTTP Request
`GET api/fetch/all/courses`


<!-- END_e48b66d39d5203dceb63e5cf3a713bb9 -->

<!-- START_7ae77552b13919d538db534ed976cb74 -->
## api/fetch/all/activities
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/fetch/all/activities" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/fetch/all/activities"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "error": null
}
```

### HTTP Request
`GET api/fetch/all/activities`


<!-- END_7ae77552b13919d538db534ed976cb74 -->

<!-- START_a1e00ab5407c4e8f792a5894cd1796b6 -->
## api/fetch/all/user-registered
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/fetch/all/user-registered" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/fetch/all/user-registered"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "error": null
}
```

### HTTP Request
`GET api/fetch/all/user-registered`


<!-- END_a1e00ab5407c4e8f792a5894cd1796b6 -->

<!-- START_181e8b38f00c8df7abc7ae63e80a63c0 -->
## api/fetch/all/user-registered-activities
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/fetch/all/user-registered-activities" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/fetch/all/user-registered-activities"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "error": null
}
```

### HTTP Request
`GET api/fetch/all/user-registered-activities`


<!-- END_181e8b38f00c8df7abc7ae63e80a63c0 -->

<!-- START_c44de5f664204f3d16cdd15971f5d912 -->
## api/fetch/daily
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/fetch/daily" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/fetch/daily"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "error": null
}
```

### HTTP Request
`GET api/fetch/daily`


<!-- END_c44de5f664204f3d16cdd15971f5d912 -->

<!-- START_c6fe10fdc0fd545e0bf84f6a2006d7a5 -->
## api/fetch/daily/user-registered
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/fetch/daily/user-registered" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/fetch/daily/user-registered"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "error": null
}
```

### HTTP Request
`GET api/fetch/daily/user-registered`


<!-- END_c6fe10fdc0fd545e0bf84f6a2006d7a5 -->

<!-- START_08033658ad10e6332a0ac5bc00e0df24 -->
## api/fetch/daily/user-registered-activities
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/fetch/daily/user-registered-activities" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/fetch/daily/user-registered-activities"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "error": null
}
```

### HTTP Request
`GET api/fetch/daily/user-registered-activities`


<!-- END_08033658ad10e6332a0ac5bc00e0df24 -->

<!-- START_52f769ef6d7e3035ff0ab011bd89003b -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/final-status" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/final-status"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "finalStatuses": [
        {
            "id": 1,
            "description": "Abierto",
            "createdAd": "2020-04-27T16:31:07.000000Z",
            "updatedAd": "2020-04-27T16:31:07.000000Z"
        },
        {
            "id": 2,
            "description": "Cerrado",
            "createdAd": "2020-04-27T16:31:07.000000Z",
            "updatedAd": "2020-04-27T16:31:07.000000Z"
        }
    ],
    "error": null
}
```

### HTTP Request
`GET api/final-status`


<!-- END_52f769ef6d7e3035ff0ab011bd89003b -->

<!-- START_2a13f19fa1f9390840f9f1e8cf501d9f -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/final-status" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/final-status"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/final-status`


<!-- END_2a13f19fa1f9390840f9f1e8cf501d9f -->

<!-- START_61c2f9f17dd7402f6d68ed583ebc04f2 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/final-status/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/final-status/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "finalStatus": {
        "id": 1,
        "description": "Abierto",
        "createdAd": "2020-04-27T16:31:07.000000Z",
        "updatedAd": "2020-04-27T16:31:07.000000Z"
    },
    "error": null
}
```

### HTTP Request
`GET api/final-status/{final_status}`


<!-- END_61c2f9f17dd7402f6d68ed583ebc04f2 -->

<!-- START_231a0c4aebf408c7058c680871b80e27 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/final-status/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/final-status/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/final-status/{final_status}`

`PATCH api/final-status/{final_status}`


<!-- END_231a0c4aebf408c7058c680871b80e27 -->

<!-- START_42d6b618d5190c4c7cd44f6309b0f6e2 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/final-status/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/final-status/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/final-status/{final_status}`


<!-- END_42d6b618d5190c4c7cd44f6309b0f6e2 -->

<!-- START_a3c6c86838579b2ab805bc5792579102 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/type-ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/type-ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "error": null,
    "statusCode": 200,
    "message": "Consulta exitosa.",
    "data": {
        "links": {
            "url": "http:\/\/127.0.0.1\/api\/v2\/type-tickets",
            "href": "\/api\/v2\/type-tickets",
            "rel": "self"
        },
        "count": 2,
        "typeTickets": [
            {
                "links": {
                    "url": "http:\/\/127.0.0.1\/api\/v2\/type-tickets\/1",
                    "href": "\/api\/v2\/type-tickets\/1",
                    "rel": "self"
                },
                "id": 1,
                "description": "Correo electrónico",
                "created_at": "2020-04-26 23:00:28",
                "updated_at": "2020-04-26 23:00:28"
            },
            {
                "links": {
                    "url": "http:\/\/127.0.0.1\/api\/v2\/type-tickets\/2",
                    "href": "\/api\/v2\/type-tickets\/2",
                    "rel": "self"
                },
                "id": 2,
                "description": "Contacto telefónico",
                "created_at": "2020-04-26 23:00:28",
                "updated_at": "2020-04-26 23:00:28"
            }
        ]
    }
}
```

### HTTP Request
`GET api/type-ticket`


<!-- END_a3c6c86838579b2ab805bc5792579102 -->

<!-- START_c7b71f8005e3c6a1b76288cb91134028 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/type-ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/type-ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/type-ticket`


<!-- END_c7b71f8005e3c6a1b76288cb91134028 -->

<!-- START_808405784ce4f4ff7d2fd6ee05448d4e -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/type-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/type-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "error": null,
    "statusCode": 200,
    "message": "Consulta exitosa.",
    "data": {
        "links": {
            "url": "http:\/\/127.0.0.1\/api\/v2\/type-tickets\/1",
            "href": "\/api\/v2\/type-tickets\/1",
            "rel": "self"
        },
        "id": 1,
        "description": "Correo electrónico",
        "created_at": "2020-04-26 23:00:28",
        "updated_at": "2020-04-26 23:00:28"
    }
}
```

### HTTP Request
`GET api/type-ticket/{type_ticket}`


<!-- END_808405784ce4f4ff7d2fd6ee05448d4e -->

<!-- START_ca3b46e65525ca22ca71b523d1e43a0c -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/type-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/type-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/type-ticket/{type_ticket}`

`PATCH api/type-ticket/{type_ticket}`


<!-- END_ca3b46e65525ca22ca71b523d1e43a0c -->

<!-- START_2a5efb06aeb54c016f11f8fb6c8b60ae -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/type-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/type-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/type-ticket/{type_ticket}`


<!-- END_2a5efb06aeb54c016f11f8fb6c8b60ae -->

<!-- START_536301667ce88ab761ee17f22b9a1948 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/motive-ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/motive-ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "motiveTickets": [
        {
            "id": 1,
            "description": "Bienvenida",
            "createdAt": "2020-04-27T16:30:36.000000Z",
            "updatedAt": "2020-04-27T16:30:36.000000Z"
        },
        {
            "id": 2,
            "description": "Problema informático",
            "createdAt": "2020-04-27T16:30:36.000000Z",
            "updatedAt": "2020-04-27T16:30:36.000000Z"
        }
    ],
    "error": null
}
```

### HTTP Request
`GET api/motive-ticket`


<!-- END_536301667ce88ab761ee17f22b9a1948 -->

<!-- START_8573d68d4aff868c944ba4465cf6e9d0 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/motive-ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/motive-ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/motive-ticket`


<!-- END_8573d68d4aff868c944ba4465cf6e9d0 -->

<!-- START_bb8d21c6a53c28bf176f70c1c5402861 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/motive-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/motive-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "motiveTicket": {
        "id": 1,
        "description": "Bienvenida",
        "createdAt": "2020-04-27T16:30:36.000000Z",
        "updatedAt": "2020-04-27T16:30:36.000000Z"
    },
    "error": null
}
```

### HTTP Request
`GET api/motive-ticket/{motive_ticket}`


<!-- END_bb8d21c6a53c28bf176f70c1c5402861 -->

<!-- START_abc225fd0412cd2465e86b76fce9d9d3 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/motive-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/motive-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/motive-ticket/{motive_ticket}`

`PATCH api/motive-ticket/{motive_ticket}`


<!-- END_abc225fd0412cd2465e86b76fce9d9d3 -->

<!-- START_7a4292d9cdce69f62acd7d7bb6a7184c -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/motive-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/motive-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/motive-ticket/{motive_ticket}`


<!-- END_7a4292d9cdce69f62acd7d7bb6a7184c -->

<!-- START_2d4849b26fa82a364bc09f9dd5edc377 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/priority-ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/priority-ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "priorityTickets": [
        {
            "id": 1,
            "description": "Alta",
            "createdAt": "27-04-2020",
            "updatedAt": "2020-04-27T16:29:59.000000Z"
        },
        {
            "id": 2,
            "description": "Media",
            "createdAt": "27-04-2020",
            "updatedAt": "2020-04-27T16:29:59.000000Z"
        },
        {
            "id": 3,
            "description": "Baja",
            "createdAt": "27-04-2020",
            "updatedAt": "2020-04-27T16:29:59.000000Z"
        }
    ],
    "error": null
}
```

### HTTP Request
`GET api/priority-ticket`


<!-- END_2d4849b26fa82a364bc09f9dd5edc377 -->

<!-- START_d0f52de6da80c15b59bb0f02d0185e79 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/priority-ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/priority-ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/priority-ticket`


<!-- END_d0f52de6da80c15b59bb0f02d0185e79 -->

<!-- START_0cf22559678e308c2499ccdebc84d044 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/priority-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/priority-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "priorityTicket": {
        "id": 1,
        "description": "Alta",
        "createdAt": "27-04-2020",
        "updatedAt": "2020-04-27T16:29:59.000000Z"
    },
    "error": null
}
```

### HTTP Request
`GET api/priority-ticket/{priority_ticket}`


<!-- END_0cf22559678e308c2499ccdebc84d044 -->

<!-- START_ebde2bc71f53df70d85940e553537796 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/priority-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/priority-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/priority-ticket/{priority_ticket}`

`PATCH api/priority-ticket/{priority_ticket}`


<!-- END_ebde2bc71f53df70d85940e553537796 -->

<!-- START_1002db1fde8206ee2b51c9678734d53a -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/priority-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/priority-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/priority-ticket/{priority_ticket}`


<!-- END_1002db1fde8206ee2b51c9678734d53a -->

<!-- START_3c520b0ccdbf5100b6f6994368e1b344 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/profile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "profiles": [
        {
            "id": 1,
            "description": "Alumno",
            "createdAt": "2020-04-27T17:58:38.000000Z",
            "updatedAt": "2020-04-27T17:58:38.000000Z"
        }
    ],
    "error": null
}
```

### HTTP Request
`GET api/profile`


<!-- END_3c520b0ccdbf5100b6f6994368e1b344 -->

<!-- START_1497ed33b433ac5263898f3caa2548a7 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/profile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile`


<!-- END_1497ed33b433ac5263898f3caa2548a7 -->

<!-- START_be5706c7ea660a4ab4fad7f9ea30d37a -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/profile/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/profile/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "profile": {
        "id": 1,
        "description": "Alumno",
        "createdAt": "2020-04-27T17:58:38.000000Z",
        "updatedAt": "2020-04-27T17:58:38.000000Z"
    },
    "error": null
}
```

### HTTP Request
`GET api/profile/{profile}`


<!-- END_be5706c7ea660a4ab4fad7f9ea30d37a -->

<!-- START_bde83db7c1eb63f9cb46499c79f6fc12 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/profile/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/profile/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/profile/{profile}`

`PATCH api/profile/{profile}`


<!-- END_bde83db7c1eb63f9cb46499c79f6fc12 -->

<!-- START_8047f9c46d962a7232f69bc38e1f2fd7 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/profile/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/profile/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/profile/{profile}`


<!-- END_8047f9c46d962a7232f69bc38e1f2fd7 -->

<!-- START_01fc43a11672802a440a34de5e43c9ec -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/role" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/role"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "roles": [],
    "error": null
}
```

### HTTP Request
`GET api/role`


<!-- END_01fc43a11672802a440a34de5e43c9ec -->

<!-- START_9da1b300a2c60ef9fb7d7bbbb9f7c300 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/role" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/role"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/role`


<!-- END_9da1b300a2c60ef9fb7d7bbbb9f7c300 -->

<!-- START_36f2eed567a95be3b454a71d1c5a4b97 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/role/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/role/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET api/role/{role}`


<!-- END_36f2eed567a95be3b454a71d1c5a4b97 -->

<!-- START_82f3bd841b4e9f9e752a55da1338ab0c -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/role/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/role/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/role/{role}`

`PATCH api/role/{role}`


<!-- END_82f3bd841b4e9f9e752a55da1338ab0c -->

<!-- START_b065139bcfb0485a301e1eda57770497 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/role/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/role/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/role/{role}`


<!-- END_b065139bcfb0485a301e1eda57770497 -->

<!-- START_75df3a48b13388bca8457b95cd18c5e9 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/status-detail-ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/status-detail-ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "statusDetailTickets": [],
    "error": null
}
```

### HTTP Request
`GET api/status-detail-ticket`


<!-- END_75df3a48b13388bca8457b95cd18c5e9 -->

<!-- START_1bfb3c6f5a94bf08c222b141ea263373 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/status-detail-ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/status-detail-ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/status-detail-ticket`


<!-- END_1bfb3c6f5a94bf08c222b141ea263373 -->

<!-- START_febd0e57dc135959f06f2c55de4b3b92 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/status-detail-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/status-detail-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET api/status-detail-ticket/{status_detail_ticket}`


<!-- END_febd0e57dc135959f06f2c55de4b3b92 -->

<!-- START_f50387707418ed7ed280d6c9d964f9d3 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/status-detail-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/status-detail-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/status-detail-ticket/{status_detail_ticket}`

`PATCH api/status-detail-ticket/{status_detail_ticket}`


<!-- END_f50387707418ed7ed280d6c9d964f9d3 -->

<!-- START_7549f395b433ae11db47c18021cd3232 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/status-detail-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/status-detail-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/status-detail-ticket/{status_detail_ticket}`


<!-- END_7549f395b433ae11db47c18021cd3232 -->

<!-- START_2ca3ea7031a0dc909f46605c676f867d -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/status-ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/status-ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "statusTickets": [
        {
            "id": 1,
            "description": "Abierto",
            "createdAt": "2020-04-27T16:28:31.000000Z",
            "updatedAt": "2020-04-27T16:28:31.000000Z"
        },
        {
            "id": 2,
            "description": "Cerrado",
            "createdAt": "2020-04-27T16:28:31.000000Z",
            "updatedAt": "2020-04-27T16:28:31.000000Z"
        }
    ],
    "error": null
}
```

### HTTP Request
`GET api/status-ticket`


<!-- END_2ca3ea7031a0dc909f46605c676f867d -->

<!-- START_dd2f0d763cdf59e6424e4ce0d75e4b3a -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/status-ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/status-ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/status-ticket`


<!-- END_dd2f0d763cdf59e6424e4ce0d75e4b3a -->

<!-- START_eb22676f5b9e3414fa67a0a75547486c -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/status-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/status-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "statusTicket": {
        "id": 1,
        "description": "Abierto",
        "createdAt": "2020-04-27T16:28:31.000000Z",
        "updatedAt": "2020-04-27T16:28:31.000000Z"
    },
    "error": null
}
```

### HTTP Request
`GET api/status-ticket/{status_ticket}`


<!-- END_eb22676f5b9e3414fa67a0a75547486c -->

<!-- START_8f9d01cfde1969a57c692d961d2bc8c5 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/status-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/status-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/status-ticket/{status_ticket}`

`PATCH api/status-ticket/{status_ticket}`


<!-- END_8f9d01cfde1969a57c692d961d2bc8c5 -->

<!-- START_3484da4759f0ea83f8d978f7377f9014 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/status-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/status-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/status-ticket/{status_ticket}`


<!-- END_3484da4759f0ea83f8d978f7377f9014 -->

<!-- START_32e1547c9014d2338473cf65a815568d -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/classroom" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/classroom"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "classrooms": [
        {
            "id": 1,
            "description": "Aula 01",
            "createdAt": "2020-04-27T17:59:35.000000Z",
            "updatedAt": "2020-04-27T17:59:35.000000Z"
        }
    ],
    "error": null
}
```

### HTTP Request
`GET api/classroom`


<!-- END_32e1547c9014d2338473cf65a815568d -->

<!-- START_4e85b8ddb1492b3617f8c4b6ae532fd6 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/classroom" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/classroom"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/classroom`


<!-- END_4e85b8ddb1492b3617f8c4b6ae532fd6 -->

<!-- START_9b55be74d5210c54643b8acf70b11dc3 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/classroom/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/classroom/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "classroom": {
        "id": 1,
        "description": "Aula 01",
        "createdAt": "2020-04-27T17:59:35.000000Z",
        "updatedAt": "2020-04-27T17:59:35.000000Z"
    },
    "error": null
}
```

### HTTP Request
`GET api/classroom/{classroom}`


<!-- END_9b55be74d5210c54643b8acf70b11dc3 -->

<!-- START_17b8d8f437b64eadeda8ba149f9e57b9 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/classroom/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/classroom/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/classroom/{classroom}`

`PATCH api/classroom/{classroom}`


<!-- END_17b8d8f437b64eadeda8ba149f9e57b9 -->

<!-- START_1aea50b4994e9029449b504159ca8606 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/classroom/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/classroom/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/classroom/{classroom}`


<!-- END_1aea50b4994e9029449b504159ca8606 -->

<!-- START_cb2b9b5939cc4ef10808ced42064b96d -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/ticket-detail" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/ticket-detail"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "ticketDetails": [],
    "error": null
}
```

### HTTP Request
`GET api/ticket-detail`


<!-- END_cb2b9b5939cc4ef10808ced42064b96d -->

<!-- START_d945755373f4678588d5e8a1662b7485 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/ticket-detail" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/ticket-detail"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/ticket-detail`


<!-- END_d945755373f4678588d5e8a1662b7485 -->

<!-- START_66a62572d9cee60f0d7eb599b26e4526 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/ticket-detail/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/ticket-detail/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET api/ticket-detail/{ticket_detail}`


<!-- END_66a62572d9cee60f0d7eb599b26e4526 -->

<!-- START_1612faf947daf450dffc9f78f2b89944 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/ticket-detail/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/ticket-detail/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/ticket-detail/{ticket_detail}`

`PATCH api/ticket-detail/{ticket_detail}`


<!-- END_1612faf947daf450dffc9f78f2b89944 -->

<!-- START_9405e0690613c66e218e7e88506754e7 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/ticket-detail/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/ticket-detail/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/ticket-detail/{ticket_detail}`


<!-- END_9405e0690613c66e218e7e88506754e7 -->

<!-- START_e547ef485a1d89c6dcc2da8b0d6aa679 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "tickets": [
        {
            "id": 4,
            "courseRegisteredUser": {
                "id": 3,
                "course_id": 2,
                "registered_user_id": 1,
                "profile_id": 1,
                "classroom_id": 1,
                "final_status_id": 1,
                "final_qualification": 1,
                "final_qualification_moodle": null,
                "last_access_registered_moodle": "Nunca",
                "created_at": "2020-04-27T17:59:44.000000Z",
                "updated_at": "2020-04-27T17:59:44.000000Z",
                "course": {
                    "id": 2,
                    "description": "Curso: Estrategias didáctica de la Enseñanza Media Técnico Profesional",
                    "id_course_moodle": 9135,
                    "category_id": 1,
                    "status": 1,
                    "created_at": "2020-04-27T17:49:52.000000Z",
                    "updated_at": "2020-04-27T17:49:52.000000Z"
                },
                "registered_user": {
                    "id": 1,
                    "rut": null,
                    "name": null,
                    "last_name": null,
                    "mother_last_name": null,
                    "email": null,
                    "phone": null,
                    "mobile": null,
                    "address": null,
                    "city": null,
                    "region": null,
                    "rbd_school": null,
                    "name_school": null,
                    "city_school": null,
                    "region_school": null,
                    "phone_school": null,
                    "id_registered_moodle": 5279,
                    "rut_registered_moodle": "8.233.470-k",
                    "name_registered_moodle": "Claudia Paola Bustos Vásquez",
                    "email_registered_moodle": "CLAUPABUV@GMAIL.COM",
                    "status_moodle": 1,
                    "user_create_id": 1,
                    "user_update_id": 1,
                    "created_at": "2020-04-27T17:57:52.000000Z",
                    "updated_at": "2020-04-27T17:57:52.000000Z"
                },
                "profile": {
                    "id": 1,
                    "description": "Alumno"
                },
                "classroom": {
                    "id": 1,
                    "description": "Aula 01"
                },
                "final_status": {
                    "id": 1,
                    "description": "Abierto"
                }
            },
            "typeTicket": {
                "id": 1,
                "description": "Correo electrónico"
            },
            "statusTicket": {
                "id": 1,
                "description": "Abierto"
            },
            "priorityTicket": {
                "id": 1,
                "description": "Alta"
            },
            "motiveTicket": {
                "id": 1,
                "description": "Bienvenida"
            },
            "userCreated": null,
            "userAssigned": {
                "id": 1,
                "rut": null,
                "name": "Developer",
                "phone": null,
                "mobile": null,
                "email": "developer@gmail.com",
                "email_verified_at": null,
                "role_id": null,
                "user_create_id": 1,
                "user_update_id": 1,
                "created_at": "2020-04-27T02:17:09.000000Z",
                "updated_at": "2020-04-27T02:17:09.000000Z"
            },
            "closingDate": "2020-04-27 14:13:53",
            "observation": "Observatión",
            "createdAt": "2020-04-27 14:13:53",
            "updatedAt": "2020-04-27 14:13:53"
        },
        {
            "id": 5,
            "courseRegisteredUser": {
                "id": 100,
                "course_id": 2,
                "registered_user_id": 98,
                "profile_id": 1,
                "classroom_id": 1,
                "final_status_id": 1,
                "final_qualification": 1,
                "final_qualification_moodle": null,
                "last_access_registered_moodle": "9 días 15 horas",
                "created_at": "2020-04-27T18:03:45.000000Z",
                "updated_at": "2020-05-02T15:56:58.000000Z",
                "course": {
                    "id": 2,
                    "description": "Curso: Estrategias didáctica de la Enseñanza Media Técnico Profesional",
                    "id_course_moodle": 9135,
                    "category_id": 1,
                    "status": 1,
                    "created_at": "2020-04-27T17:49:52.000000Z",
                    "updated_at": "2020-04-27T17:49:52.000000Z"
                },
                "registered_user": {
                    "id": 98,
                    "rut": null,
                    "name": null,
                    "last_name": null,
                    "mother_last_name": null,
                    "email": null,
                    "phone": null,
                    "mobile": null,
                    "address": null,
                    "city": null,
                    "region": null,
                    "rbd_school": null,
                    "name_school": null,
                    "city_school": null,
                    "region_school": null,
                    "phone_school": null,
                    "id_registered_moodle": 103007,
                    "rut_registered_moodle": "21.238.301-5",
                    "name_registered_moodle": "RAQUEL  ROSARIO GAVILANES VERA",
                    "email_registered_moodle": "RAQUELGAVILANES@HOTMAIL.COM",
                    "status_moodle": 1,
                    "user_create_id": 1,
                    "user_update_id": 1,
                    "created_at": "2020-04-27T18:03:45.000000Z",
                    "updated_at": "2020-04-27T18:03:45.000000Z"
                },
                "profile": {
                    "id": 1,
                    "description": "Alumno"
                },
                "classroom": {
                    "id": 1,
                    "description": "Aula 01"
                },
                "final_status": {
                    "id": 1,
                    "description": "Abierto"
                }
            },
            "typeTicket": {
                "id": 1,
                "description": "Correo electrónico"
            },
            "statusTicket": {
                "id": 1,
                "description": "Abierto"
            },
            "priorityTicket": {
                "id": 1,
                "description": "Alta"
            },
            "motiveTicket": {
                "id": 1,
                "description": "Bienvenida"
            },
            "userCreated": null,
            "userAssigned": {
                "id": 1,
                "rut": null,
                "name": "Developer",
                "phone": null,
                "mobile": null,
                "email": "developer@gmail.com",
                "email_verified_at": null,
                "role_id": null,
                "user_create_id": 1,
                "user_update_id": 1,
                "created_at": "2020-04-27T02:17:09.000000Z",
                "updated_at": "2020-04-27T02:17:09.000000Z"
            },
            "closingDate": "2020-04-27 14:15:22",
            "observation": "Observación 1",
            "createdAt": "2020-04-27 14:15:22",
            "updatedAt": "2020-04-27 14:15:22"
        },
        {
            "id": 6,
            "courseRegisteredUser": {
                "id": 300,
                "course_id": 2,
                "registered_user_id": 298,
                "profile_id": 1,
                "classroom_id": 1,
                "final_status_id": 1,
                "final_qualification": 1,
                "final_qualification_moodle": null,
                "last_access_registered_moodle": "47 días 1 hora",
                "created_at": "2020-04-27T18:03:46.000000Z",
                "updated_at": "2020-05-02T15:56:59.000000Z",
                "course": {
                    "id": 2,
                    "description": "Curso: Estrategias didáctica de la Enseñanza Media Técnico Profesional",
                    "id_course_moodle": 9135,
                    "category_id": 1,
                    "status": 1,
                    "created_at": "2020-04-27T17:49:52.000000Z",
                    "updated_at": "2020-04-27T17:49:52.000000Z"
                },
                "registered_user": {
                    "id": 298,
                    "rut": null,
                    "name": null,
                    "last_name": null,
                    "mother_last_name": null,
                    "email": null,
                    "phone": null,
                    "mobile": null,
                    "address": null,
                    "city": null,
                    "region": null,
                    "rbd_school": null,
                    "name_school": null,
                    "city_school": null,
                    "region_school": null,
                    "phone_school": null,
                    "id_registered_moodle": 398719,
                    "rut_registered_moodle": "16.233.805-6",
                    "name_registered_moodle": "SEBASTIAN ALBERTO QUEZADA CARRAMIÑANA",
                    "email_registered_moodle": "SEBASTIAN.QUEZADA26@GMAIL.COM",
                    "status_moodle": 1,
                    "user_create_id": 1,
                    "user_update_id": 1,
                    "created_at": "2020-04-27T18:03:46.000000Z",
                    "updated_at": "2020-04-27T18:03:46.000000Z"
                },
                "profile": {
                    "id": 1,
                    "description": "Alumno"
                },
                "classroom": {
                    "id": 1,
                    "description": "Aula 01"
                },
                "final_status": {
                    "id": 1,
                    "description": "Abierto"
                }
            },
            "typeTicket": {
                "id": 2,
                "description": "Contacto telefónico"
            },
            "statusTicket": {
                "id": 1,
                "description": "Abierto"
            },
            "priorityTicket": {
                "id": 1,
                "description": "Alta"
            },
            "motiveTicket": {
                "id": 1,
                "description": "Bienvenida"
            },
            "userCreated": null,
            "userAssigned": {
                "id": 1,
                "rut": null,
                "name": "Developer",
                "phone": null,
                "mobile": null,
                "email": "developer@gmail.com",
                "email_verified_at": null,
                "role_id": null,
                "user_create_id": 1,
                "user_update_id": 1,
                "created_at": "2020-04-27T02:17:09.000000Z",
                "updated_at": "2020-04-27T02:17:09.000000Z"
            },
            "closingDate": "2020-05-01 18:56:16",
            "observation": "Obs",
            "createdAt": "2020-05-01 18:56:16",
            "updatedAt": "2020-05-01 18:56:16"
        },
        {
            "id": 7,
            "courseRegisteredUser": {
                "id": 754,
                "course_id": 3,
                "registered_user_id": 746,
                "profile_id": 1,
                "classroom_id": 1,
                "final_status_id": 1,
                "final_qualification": 1,
                "final_qualification_moodle": null,
                "last_access_registered_moodle": "21 días 15 horas",
                "created_at": "2020-04-27T18:03:47.000000Z",
                "updated_at": "2020-05-02T15:57:00.000000Z",
                "course": {
                    "id": 3,
                    "description": "Curso: El juego como estrategia didáctica para el aprendizaje (Aula 01 a 12)",
                    "id_course_moodle": 8986,
                    "category_id": 2,
                    "status": 1,
                    "created_at": "2020-04-27T17:49:52.000000Z",
                    "updated_at": "2020-04-27T17:49:52.000000Z"
                },
                "registered_user": {
                    "id": 746,
                    "rut": null,
                    "name": null,
                    "last_name": null,
                    "mother_last_name": null,
                    "email": null,
                    "phone": null,
                    "mobile": null,
                    "address": null,
                    "city": null,
                    "region": null,
                    "rbd_school": null,
                    "name_school": null,
                    "city_school": null,
                    "region_school": null,
                    "phone_school": null,
                    "id_registered_moodle": 399055,
                    "rut_registered_moodle": "14.082.878-5",
                    "name_registered_moodle": "PAMELA ANDREA SOLÍS RIVERA",
                    "email_registered_moodle": "PAME.SOLIS29@GMAIL.COM",
                    "status_moodle": 1,
                    "user_create_id": 1,
                    "user_update_id": 1,
                    "created_at": "2020-04-27T18:03:47.000000Z",
                    "updated_at": "2020-04-27T18:03:47.000000Z"
                },
                "profile": {
                    "id": 1,
                    "description": "Alumno"
                },
                "classroom": {
                    "id": 1,
                    "description": "Aula 01"
                },
                "final_status": {
                    "id": 1,
                    "description": "Abierto"
                }
            },
            "typeTicket": {
                "id": 1,
                "description": "Correo electrónico"
            },
            "statusTicket": {
                "id": 1,
                "description": "Abierto"
            },
            "priorityTicket": {
                "id": 1,
                "description": "Alta"
            },
            "motiveTicket": {
                "id": 1,
                "description": "Bienvenida"
            },
            "userCreated": null,
            "userAssigned": {
                "id": 1,
                "rut": null,
                "name": "Developer",
                "phone": null,
                "mobile": null,
                "email": "developer@gmail.com",
                "email_verified_at": null,
                "role_id": null,
                "user_create_id": 1,
                "user_update_id": 1,
                "created_at": "2020-04-27T02:17:09.000000Z",
                "updated_at": "2020-04-27T02:17:09.000000Z"
            },
            "closingDate": "2020-05-02 23:31:18",
            "observation": "Ons",
            "createdAt": "2020-05-02 23:31:18",
            "updatedAt": "2020-05-02 23:31:18"
        }
    ],
    "error": null
}
```

### HTTP Request
`GET api/ticket`


<!-- END_e547ef485a1d89c6dcc2da8b0d6aa679 -->

<!-- START_2a37f4579728e7fcdd1ad38607842fa2 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/ticket`


<!-- END_2a37f4579728e7fcdd1ad38607842fa2 -->

<!-- START_09beb0b65ba279c8dca908be1e9f0fc0 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET api/ticket/{ticket}`


<!-- END_09beb0b65ba279c8dca908be1e9f0fc0 -->

<!-- START_f913156002bd7568f7e004b43e22363d -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/ticket/{ticket}`

`PATCH api/ticket/{ticket}`


<!-- END_f913156002bd7568f7e004b43e22363d -->

<!-- START_e97b94853653ab1aa033f3e93ab5a7a1 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/ticket/{ticket}`


<!-- END_e97b94853653ab1aa033f3e93ab5a7a1 -->

<!-- START_1e903688e2ce47e7e30ebb7e697e1a0a -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/alert" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/alert"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "error": null,
    "statusCode": 200,
    "message": "Consulta exitosa.",
    "data": {
        "links": {
            "url": "http:\/\/127.0.0.1\/api\/v2\/alerts",
            "href": "\/api\/v2\/alerts",
            "rel": "self"
        },
        "count": 2,
        "alerts": [
            {
                "links": {
                    "url": "http:\/\/127.0.0.1\/api\/v2\/alerts\/2",
                    "href": "\/api\/v2\/alerts\/2",
                    "rel": "self"
                },
                "alert": {
                    "id": 2,
                    "time": "12:09:33",
                    "date": "2020-05-01",
                    "statusReminder": 1,
                    "statusNotification": 1,
                    "comment": "Mi comment",
                    "ticket": {
                        "id": 4,
                        "course_registered_user_id": 3,
                        "type_ticket_id": 1,
                        "status_ticket_id": 1,
                        "priority_ticket_id": 1,
                        "source_ticket_id": 1,
                        "motive_ticket_id": 1,
                        "user_create_id": 1,
                        "user_assigned_id": 1,
                        "closing_date": "2020-04-27 14:13:53",
                        "observation": "Observatión",
                        "created_at": "2020-04-27T18:13:53.000000Z",
                        "updated_at": "2020-04-27T18:13:53.000000Z",
                        "course_registered_user": {
                            "id": 3,
                            "course_id": 2,
                            "registered_user_id": 1,
                            "profile_id": 1,
                            "classroom_id": 1,
                            "final_status_id": 1,
                            "final_qualification": 1,
                            "final_qualification_moodle": null,
                            "last_access_registered_moodle": "Nunca",
                            "created_at": "2020-04-27T17:59:44.000000Z",
                            "updated_at": "2020-04-27T17:59:44.000000Z",
                            "course": {
                                "id": 2,
                                "description": "Curso: Estrategias didáctica de la Enseñanza Media Técnico Profesional",
                                "id_course_moodle": 9135,
                                "category_id": 1,
                                "status": 1,
                                "created_at": "2020-04-27T17:49:52.000000Z",
                                "updated_at": "2020-04-27T17:49:52.000000Z"
                            },
                            "registered_user": {
                                "id": 1,
                                "rut": null,
                                "name": null,
                                "last_name": null,
                                "mother_last_name": null,
                                "email": null,
                                "phone": null,
                                "mobile": null,
                                "address": null,
                                "city": null,
                                "region": null,
                                "rbd_school": null,
                                "name_school": null,
                                "city_school": null,
                                "region_school": null,
                                "phone_school": null,
                                "id_registered_moodle": 5279,
                                "rut_registered_moodle": "8.233.470-k",
                                "name_registered_moodle": "Claudia Paola Bustos Vásquez",
                                "email_registered_moodle": "CLAUPABUV@GMAIL.COM",
                                "status_moodle": 1,
                                "user_create_id": 1,
                                "user_update_id": 1,
                                "created_at": "2020-04-27T17:57:52.000000Z",
                                "updated_at": "2020-04-27T17:57:52.000000Z"
                            },
                            "profile": {
                                "id": 1,
                                "description": "Alumno"
                            },
                            "classroom": {
                                "id": 1,
                                "description": "Aula 01"
                            },
                            "final_status": {
                                "id": 1,
                                "description": "Abierto"
                            }
                        },
                        "type_ticket": {
                            "id": 1,
                            "description": "Correo electrónico"
                        },
                        "status_ticket": {
                            "id": 1,
                            "description": "Abierto"
                        },
                        "priority_ticket": {
                            "id": 1,
                            "description": "Alta"
                        },
                        "motive_ticket": {
                            "id": 1,
                            "description": "Bienvenida"
                        }
                    },
                    "user": {
                        "id": 1,
                        "rut": null,
                        "name": "Developer",
                        "phone": null,
                        "mobile": null,
                        "email": "developer@gmail.com",
                        "email_verified_at": null,
                        "role_id": null,
                        "user_create_id": 1,
                        "user_update_id": 1,
                        "created_at": "2020-04-27T02:17:09.000000Z",
                        "updated_at": "2020-04-27T02:17:09.000000Z"
                    },
                    "created_at": "2020-05-01 12:09:33",
                    "updated_at": "2020-05-01 12:09:33"
                }
            },
            {
                "links": {
                    "url": "http:\/\/127.0.0.1\/api\/v2\/alerts\/3",
                    "href": "\/api\/v2\/alerts\/3",
                    "rel": "self"
                },
                "alert": {
                    "id": 3,
                    "time": "12:48:33",
                    "date": "2020-05-01",
                    "statusReminder": 1,
                    "statusNotification": 1,
                    "comment": "New comment edited",
                    "ticket": {
                        "id": 5,
                        "course_registered_user_id": 100,
                        "type_ticket_id": 1,
                        "status_ticket_id": 1,
                        "priority_ticket_id": 1,
                        "source_ticket_id": 1,
                        "motive_ticket_id": 1,
                        "user_create_id": 1,
                        "user_assigned_id": 1,
                        "closing_date": "2020-04-27 14:15:22",
                        "observation": "Observación 1",
                        "created_at": "2020-04-27T18:15:22.000000Z",
                        "updated_at": "2020-04-27T18:15:22.000000Z",
                        "course_registered_user": {
                            "id": 100,
                            "course_id": 2,
                            "registered_user_id": 98,
                            "profile_id": 1,
                            "classroom_id": 1,
                            "final_status_id": 1,
                            "final_qualification": 1,
                            "final_qualification_moodle": null,
                            "last_access_registered_moodle": "9 días 15 horas",
                            "created_at": "2020-04-27T18:03:45.000000Z",
                            "updated_at": "2020-05-02T15:56:58.000000Z",
                            "course": {
                                "id": 2,
                                "description": "Curso: Estrategias didáctica de la Enseñanza Media Técnico Profesional",
                                "id_course_moodle": 9135,
                                "category_id": 1,
                                "status": 1,
                                "created_at": "2020-04-27T17:49:52.000000Z",
                                "updated_at": "2020-04-27T17:49:52.000000Z"
                            },
                            "registered_user": {
                                "id": 98,
                                "rut": null,
                                "name": null,
                                "last_name": null,
                                "mother_last_name": null,
                                "email": null,
                                "phone": null,
                                "mobile": null,
                                "address": null,
                                "city": null,
                                "region": null,
                                "rbd_school": null,
                                "name_school": null,
                                "city_school": null,
                                "region_school": null,
                                "phone_school": null,
                                "id_registered_moodle": 103007,
                                "rut_registered_moodle": "21.238.301-5",
                                "name_registered_moodle": "RAQUEL  ROSARIO GAVILANES VERA",
                                "email_registered_moodle": "RAQUELGAVILANES@HOTMAIL.COM",
                                "status_moodle": 1,
                                "user_create_id": 1,
                                "user_update_id": 1,
                                "created_at": "2020-04-27T18:03:45.000000Z",
                                "updated_at": "2020-04-27T18:03:45.000000Z"
                            },
                            "profile": {
                                "id": 1,
                                "description": "Alumno"
                            },
                            "classroom": {
                                "id": 1,
                                "description": "Aula 01"
                            },
                            "final_status": {
                                "id": 1,
                                "description": "Abierto"
                            }
                        },
                        "type_ticket": {
                            "id": 1,
                            "description": "Correo electrónico"
                        },
                        "status_ticket": {
                            "id": 1,
                            "description": "Abierto"
                        },
                        "priority_ticket": {
                            "id": 1,
                            "description": "Alta"
                        },
                        "motive_ticket": {
                            "id": 1,
                            "description": "Bienvenida"
                        }
                    },
                    "user": {
                        "id": 1,
                        "rut": null,
                        "name": "Developer",
                        "phone": null,
                        "mobile": null,
                        "email": "developer@gmail.com",
                        "email_verified_at": null,
                        "role_id": null,
                        "user_create_id": 1,
                        "user_update_id": 1,
                        "created_at": "2020-04-27T02:17:09.000000Z",
                        "updated_at": "2020-04-27T02:17:09.000000Z"
                    },
                    "created_at": "2020-05-01 12:09:33",
                    "updated_at": "2020-05-01 12:48:45"
                }
            }
        ]
    }
}
```

### HTTP Request
`GET api/alert`


<!-- END_1e903688e2ce47e7e30ebb7e697e1a0a -->

<!-- START_78de4c323ffa814c844b159b238663c0 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/alert" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/alert"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/alert`


<!-- END_78de4c323ffa814c844b159b238663c0 -->

<!-- START_d78926919cd4bbd2262cff3abc24cfb1 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/alert/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/alert/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": false,
    "data": null,
    "error": "No content",
    "statusCode": 204,
    "message": "Registro no encontrado"
}
```

### HTTP Request
`GET api/alert/{alert}`


<!-- END_d78926919cd4bbd2262cff3abc24cfb1 -->

<!-- START_0889a498330b63d9810d35204da07914 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/alert/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/alert/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/alert/{alert}`

`PATCH api/alert/{alert}`


<!-- END_0889a498330b63d9810d35204da07914 -->

<!-- START_03b1fdaf030702270ed23406b7ca4716 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/alert/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/alert/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/alert/{alert}`


<!-- END_03b1fdaf030702270ed23406b7ca4716 -->

<!-- START_9fd4e9d17f428a3dfb700c83dd25354e -->
## api/upload-file/excel
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/upload-file/excel" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/upload-file/excel"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "rut": "15654738-7",
        "nombre": "roberto",
        "last_name": "araneda",
        "mother_last_name": "espinoza"
    },
    {
        "rut": "16317005-1",
        "nombre": "claudia",
        "last_name": "alarcon",
        "mother_last_name": "lazo"
    },
    {
        "rut": "15565656-0",
        "nombre": "test",
        "last_name": "test",
        "mother_last_name": "test"
    },
    {
        "rut": null,
        "nombre": null,
        "last_name": null,
        "mother_last_name": null
    },
    {
        "rut": null,
        "nombre": null,
        "last_name": null,
        "mother_last_name": null
    },
    {
        "rut": null,
        "nombre": null,
        "last_name": null,
        "mother_last_name": null
    },
    {
        "rut": null,
        "nombre": null,
        "last_name": null,
        "mother_last_name": null
    }
]
```

### HTTP Request
`GET api/upload-file/excel`


<!-- END_9fd4e9d17f428a3dfb700c83dd25354e -->

<!-- START_a925a8d22b3615f12fca79456d286859 -->
## Login user and create token

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/auth/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/auth/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/auth/login`


<!-- END_a925a8d22b3615f12fca79456d286859 -->

<!-- START_9357c0a600c785fe4f708897facae8b8 -->
## Create user

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/auth/signup" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/auth/signup"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/auth/signup`


<!-- END_9357c0a600c785fe4f708897facae8b8 -->

<!-- START_ff6d656b6d81a61adda963b8702034d2 -->
## Get the authenticated User

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/auth/user" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/auth/user"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/auth/user`


<!-- END_ff6d656b6d81a61adda963b8702034d2 -->

<!-- START_16928cb8fc6adf2d9bb675d62a2095c5 -->
## Logout user (Revoke the token)

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/auth/logout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/auth/logout"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/auth/logout`


<!-- END_16928cb8fc6adf2d9bb675d62a2095c5 -->

<!-- START_e307ec43d60cd5a1125b29ada44f8b79 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/type-tickets" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/type-tickets"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/type-tickets`


<!-- END_e307ec43d60cd5a1125b29ada44f8b79 -->

<!-- START_e218fd2490c8d3c3ca4e9df52226873a -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/v2/type-tickets" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/type-tickets"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/v2/type-tickets`


<!-- END_e218fd2490c8d3c3ca4e9df52226873a -->

<!-- START_ced6b4ed2487d1a010775c6d9382eecb -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/type-tickets/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/type-tickets/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/type-tickets/{type_ticket}`


<!-- END_ced6b4ed2487d1a010775c6d9382eecb -->

<!-- START_134e6104352625461c26b6982c46a55a -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/v2/type-tickets/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/type-tickets/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/v2/type-tickets/{type_ticket}`

`PATCH api/v2/type-tickets/{type_ticket}`


<!-- END_134e6104352625461c26b6982c46a55a -->

<!-- START_69f5a4f9642c39219ff5d452cb9037d0 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/v2/type-tickets/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/type-tickets/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/v2/type-tickets/{type_ticket}`


<!-- END_69f5a4f9642c39219ff5d452cb9037d0 -->

<!-- START_95d2e24a602465170307b4b9a18ae6da -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/activities" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/activities"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/activities`


<!-- END_95d2e24a602465170307b4b9a18ae6da -->

<!-- START_235ccdf3590f1ae1cb5f31870da4a44b -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/v2/activities" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/activities"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/v2/activities`


<!-- END_235ccdf3590f1ae1cb5f31870da4a44b -->

<!-- START_5031520e66564b6d4ef65585d3d3551f -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/activities/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/activities/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/activities/{activity}`


<!-- END_5031520e66564b6d4ef65585d3d3551f -->

<!-- START_c1ec476708f89a753305ee46ca76535c -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/v2/activities/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/activities/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/v2/activities/{activity}`

`PATCH api/v2/activities/{activity}`


<!-- END_c1ec476708f89a753305ee46ca76535c -->

<!-- START_4fa1b6b9495a9918d140622c9561ae10 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/v2/activities/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/activities/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/v2/activities/{activity}`


<!-- END_4fa1b6b9495a9918d140622c9561ae10 -->

<!-- START_191ae651323ecb4e160c0629af473219 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/alerts" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/alerts"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/alerts`


<!-- END_191ae651323ecb4e160c0629af473219 -->

<!-- START_4f6163055597f2528fb34328adc85bda -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/v2/alerts" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/alerts"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/v2/alerts`


<!-- END_4f6163055597f2528fb34328adc85bda -->

<!-- START_69e03db5153a4c986c336a59c23699b9 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/alerts/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/alerts/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/alerts/{alert}`


<!-- END_69e03db5153a4c986c336a59c23699b9 -->

<!-- START_837fbbebfd0d7cacb219053d449c310f -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/v2/alerts/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/alerts/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/v2/alerts/{alert}`

`PATCH api/v2/alerts/{alert}`


<!-- END_837fbbebfd0d7cacb219053d449c310f -->

<!-- START_93a5f02287248f6585ad332675bf391a -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/v2/alerts/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/alerts/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/v2/alerts/{alert}`


<!-- END_93a5f02287248f6585ad332675bf391a -->

<!-- START_94d07e72ebb9866562ac55dedcf3994d -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/categories" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/categories"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/categories`


<!-- END_94d07e72ebb9866562ac55dedcf3994d -->

<!-- START_9931583746c5663dc48312036345948b -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/v2/categories" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/categories"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/v2/categories`


<!-- END_9931583746c5663dc48312036345948b -->

<!-- START_34cff46a3c56ad904f624d8e5ffb2c39 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/categories/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/categories/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/categories/{category}`


<!-- END_34cff46a3c56ad904f624d8e5ffb2c39 -->

<!-- START_35ce69cfea285a028c8d68c7f702eb6c -->
## Updated the specified resource.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/v2/categories/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/categories/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/v2/categories/{category}`

`PATCH api/v2/categories/{category}`


<!-- END_35ce69cfea285a028c8d68c7f702eb6c -->

<!-- START_6aef3c403afb1eafcfdd51b7136e1998 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/courses" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/courses"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/courses`


<!-- END_6aef3c403afb1eafcfdd51b7136e1998 -->

<!-- START_c91ec2a527e7dfee4bade913f6cc6baf -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/v2/courses" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/courses"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/v2/courses`


<!-- END_c91ec2a527e7dfee4bade913f6cc6baf -->

<!-- START_9cae39f7fccfcdc203368f2df17d7f90 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/courses/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/courses/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/courses/{course}`


<!-- END_9cae39f7fccfcdc203368f2df17d7f90 -->

<!-- START_7923e154bc1d838a70b86efae8840e8a -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/v2/courses/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/courses/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/v2/courses/{course}`

`PATCH api/v2/courses/{course}`


<!-- END_7923e154bc1d838a70b86efae8840e8a -->

<!-- START_dc0a2fdb709a4a3f124eccbd8a1043f0 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/v2/courses/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/courses/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/v2/courses/{course}`


<!-- END_dc0a2fdb709a4a3f124eccbd8a1043f0 -->

<!-- START_9f24b60bae02f95478d704bb25231992 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/platforms" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/platforms"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/platforms`


<!-- END_9f24b60bae02f95478d704bb25231992 -->

<!-- START_a1023823e1bcbf95250963af9a643e02 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/v2/platforms" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/platforms"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/v2/platforms`


<!-- END_a1023823e1bcbf95250963af9a643e02 -->

<!-- START_919d5242b4eeaebcef7ee75e66e7d585 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/platforms/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/platforms/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/platforms/{platform}`


<!-- END_919d5242b4eeaebcef7ee75e66e7d585 -->

<!-- START_59a459b4ae1afee675a8f731f9f94808 -->
## Updated the specified resource.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/v2/platforms/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/platforms/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/v2/platforms/{platform}`

`PATCH api/v2/platforms/{platform}`


<!-- END_59a459b4ae1afee675a8f731f9f94808 -->

<!-- START_17f4254a84e218331d6388f5f6cffb19 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/tickets" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/tickets"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/tickets`


<!-- END_17f4254a84e218331d6388f5f6cffb19 -->

<!-- START_554a086fedab41b01a9102fca3163787 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/v2/tickets" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/tickets"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/v2/tickets`


<!-- END_554a086fedab41b01a9102fca3163787 -->

<!-- START_035f6e17bed7924106317e8473f43c7a -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/tickets/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/tickets/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/tickets/{ticket}`


<!-- END_035f6e17bed7924106317e8473f43c7a -->

<!-- START_e601c0f6b4ce47b48a9a206018961208 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/v2/tickets/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/tickets/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/v2/tickets/{ticket}`

`PATCH api/v2/tickets/{ticket}`


<!-- END_e601c0f6b4ce47b48a9a206018961208 -->

<!-- START_933f7b9360ea9431807eebb06aeb8d63 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/v2/tickets/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/tickets/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/v2/tickets/{ticket}`


<!-- END_933f7b9360ea9431807eebb06aeb8d63 -->

<!-- START_0edae1b9832f6c5a9d52cef0f08dc33a -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/activity-course-users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/activity-course-users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/activity-course-users`


<!-- END_0edae1b9832f6c5a9d52cef0f08dc33a -->

<!-- START_5ba21f95a8fd3fec22aec475589296c6 -->
## api/v2/activity-course-users
> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/v2/activity-course-users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/activity-course-users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/v2/activity-course-users`


<!-- END_5ba21f95a8fd3fec22aec475589296c6 -->

<!-- START_4f18968847e2013832047fdd284f3c7e -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/activity-course-users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/activity-course-users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/activity-course-users/{activity_course_user}`


<!-- END_4f18968847e2013832047fdd284f3c7e -->

<!-- START_b5d854389c1eedfbb68852747169f9d0 -->
## api/v2/activity-course-users/{activity_course_user}
> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/v2/activity-course-users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/activity-course-users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/v2/activity-course-users/{activity_course_user}`

`PATCH api/v2/activity-course-users/{activity_course_user}`


<!-- END_b5d854389c1eedfbb68852747169f9d0 -->

<!-- START_3889fd66846e839eddc0ff92d8c16365 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/v2/activity-course-users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/activity-course-users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/v2/activity-course-users/{activity_course_user}`


<!-- END_3889fd66846e839eddc0ff92d8c16365 -->

<!-- START_6cf64cf7fa84d514549a5481d7f8f304 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/course-registered-users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/course-registered-users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/course-registered-users`


<!-- END_6cf64cf7fa84d514549a5481d7f8f304 -->

<!-- START_4815f9908553a23d04ab4205a1514f5f -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/v2/course-registered-users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/course-registered-users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/v2/course-registered-users`


<!-- END_4815f9908553a23d04ab4205a1514f5f -->

<!-- START_dfcae8b7a284e5947f4698ee8979e568 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/course-registered-users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/course-registered-users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/course-registered-users/{course_registered_user}`


<!-- END_dfcae8b7a284e5947f4698ee8979e568 -->

<!-- START_fd0466fb9e94c2f30551a07a15c78ae6 -->
## api/v2/course-registered-users/{course_registered_user}
> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/v2/course-registered-users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/course-registered-users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/v2/course-registered-users/{course_registered_user}`

`PATCH api/v2/course-registered-users/{course_registered_user}`


<!-- END_fd0466fb9e94c2f30551a07a15c78ae6 -->

<!-- START_bfecf37a6628b1eb06ffafac8ed83c44 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/v2/course-registered-users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/course-registered-users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/v2/course-registered-users/{course_registered_user}`


<!-- END_bfecf37a6628b1eb06ffafac8ed83c44 -->

<!-- START_0ede783a676f6e7e702bde5114b9c8fd -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/registered-users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/registered-users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/registered-users`


<!-- END_0ede783a676f6e7e702bde5114b9c8fd -->

<!-- START_b1d5ee47a563f00ebbf3942d7071a553 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/v2/registered-users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/registered-users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/v2/registered-users`


<!-- END_b1d5ee47a563f00ebbf3942d7071a553 -->

<!-- START_a7887e90f3b924125d4c92e4eb4bdef8 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/registered-users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/registered-users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/registered-users/{registered_user}`


<!-- END_a7887e90f3b924125d4c92e4eb4bdef8 -->

<!-- START_820ed65ab86a08b91caae3de3980f2d2 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/v2/registered-users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/registered-users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/v2/registered-users/{registered_user}`

`PATCH api/v2/registered-users/{registered_user}`


<!-- END_820ed65ab86a08b91caae3de3980f2d2 -->

<!-- START_9f72874d25885ea62d70ce6a77089f1e -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/v2/registered-users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/registered-users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/v2/registered-users/{registered_user}`


<!-- END_9f72874d25885ea62d70ce6a77089f1e -->

<!-- START_594ae13f859f88d3dadf5a248d780689 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/status-ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/status-ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/status-ticket`


<!-- END_594ae13f859f88d3dadf5a248d780689 -->

<!-- START_21be7fffa9da902d5ee86451f3973788 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1/api/v2/status-ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/status-ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/v2/status-ticket`


<!-- END_21be7fffa9da902d5ee86451f3973788 -->

<!-- START_3e72dfc9d692b9b6a3d7ca0872936cc0 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/status-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/status-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/status-ticket/{status_ticket}`


<!-- END_3e72dfc9d692b9b6a3d7ca0872936cc0 -->

<!-- START_8ab6687c2dcff7e723dd3372e1da25cb -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1/api/v2/status-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/status-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/v2/status-ticket/{status_ticket}`

`PATCH api/v2/status-ticket/{status_ticket}`


<!-- END_8ab6687c2dcff7e723dd3372e1da25cb -->

<!-- START_e52d546fee9a551af9de810053cbb766 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1/api/v2/status-ticket/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/status-ticket/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/v2/status-ticket/{status_ticket}`


<!-- END_e52d546fee9a551af9de810053cbb766 -->

<!-- START_1cd3e104c9d8dae6ddd0c8d914445ed0 -->
## api/v2/registered-user/{rut}
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/registered-user/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/registered-user/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/registered-user/{rut}`


<!-- END_1cd3e104c9d8dae6ddd0c8d914445ed0 -->

<!-- START_39b1eedf2c9371282c1aadf223bddecd -->
## api/v2/activity-course-registered-user/{id}
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/activity-course-registered-user/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/activity-course-registered-user/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/activity-course-registered-user/{id}`


<!-- END_39b1eedf2c9371282c1aadf223bddecd -->

<!-- START_bf9f8ba67e81ec80180d58efef9a4af3 -->
## api/v2/type-tickets/{type_ticket}/tickets
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/type-tickets/1/tickets" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/type-tickets/1/tickets"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/type-tickets/{type_ticket}/tickets`


<!-- END_bf9f8ba67e81ec80180d58efef9a4af3 -->

<!-- START_b15051f09964060c2749b7d8fd8b3239 -->
## api/v2/activities/{activity}/activity-course-users
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/activities/1/activity-course-users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/activities/1/activity-course-users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/activities/{activity}/activity-course-users`


<!-- END_b15051f09964060c2749b7d8fd8b3239 -->

<!-- START_48c461c31bbd959a9d53f9f1a44a2b8c -->
## Display a list of courses.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/categories/1/courses" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/categories/1/courses"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/categories/{category}/courses`


<!-- END_48c461c31bbd959a9d53f9f1a44a2b8c -->

<!-- START_1a90c202772a13ec11f64fefc2c9f686 -->
## api/v2/courses/{course}/activities
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/courses/1/activities" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/courses/1/activities"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/courses/{course}/activities`


<!-- END_1a90c202772a13ec11f64fefc2c9f686 -->

<!-- START_b567ab6792156a05b47237e3305891db -->
## api/v2/courses/{course}/registered-users
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/courses/1/registered-users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/courses/1/registered-users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/courses/{course}/registered-users`


<!-- END_b567ab6792156a05b47237e3305891db -->

<!-- START_64cdd93694bf7d08118e7bef1448b7f0 -->
## api/v2/courses/{course}/registered-users/{registered_user}
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/courses/1/registered-users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/courses/1/registered-users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/courses/{course}/registered-users/{registered_user}`


<!-- END_64cdd93694bf7d08118e7bef1448b7f0 -->

<!-- START_71f0ae5d034033482e3c78abc4309118 -->
## api/v2/courses/{course}/registered-users/{registered_user}/activities
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/courses/1/registered-users/1/activities" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/courses/1/registered-users/1/activities"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/courses/{course}/registered-users/{registered_user}/activities`


<!-- END_71f0ae5d034033482e3c78abc4309118 -->

<!-- START_abe9f0711abd831f26874700307ce522 -->
## Display a list of a specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/platforms/1/categories" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/platforms/1/categories"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/platforms/{platform}/categories`


<!-- END_abe9f0711abd831f26874700307ce522 -->

<!-- START_56af8b0e7f974bae5560f64ff636f82b -->
## api/v2/registered-users/{registered_user}/courses
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/registered-users/1/courses" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/registered-users/1/courses"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/registered-users/{registered_user}/courses`


<!-- END_56af8b0e7f974bae5560f64ff636f82b -->

<!-- START_fae76ee6c5e8d1ba4bc912466a3459db -->
## api/v2/registered-users/{registered_user}/courses/{course}
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/registered-users/1/courses/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/registered-users/1/courses/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/registered-users/{registered_user}/courses/{course}`


<!-- END_fae76ee6c5e8d1ba4bc912466a3459db -->

<!-- START_1a598bfce9100fc00262e199ef5c21a2 -->
## api/v2/registered-users/{registered_user}/courses/{course}/activities
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/registered-users/1/courses/1/activities" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/registered-users/1/courses/1/activities"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/registered-users/{registered_user}/courses/{course}/activities`


<!-- END_1a598bfce9100fc00262e199ef5c21a2 -->

<!-- START_d93ff5af2970e7c0d0f47db6d46dfccd -->
## api/v2/registered-users/{registered_user}/tickets
> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1/api/v2/registered-users/1/tickets" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1/api/v2/registered-users/1/tickets"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/v2/registered-users/{registered_user}/tickets`


<!-- END_d93ff5af2970e7c0d0f47db6d46dfccd -->


