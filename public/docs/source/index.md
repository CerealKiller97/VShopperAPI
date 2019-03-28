---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
-
---
<!-- START_INFO -->
# VShopperAPI routes


<!-- END_INFO -->

<!-- START_a09d20357336aa979ecd8e3972ac9168 -->


<!-- END_a9a802c25737cca5324125e5f60b72a5 -->

<!-- START_2aec2942df5caa3ceb291b37cb3f8441 -->
# Accounts

## Get authenticated user&#039;s info

`GET api/accounts`


> Request:

```bash
curl -X GET -G "http://localhost/api/accounts"
```

```javascript
const url = new URL("http://localhost/api/accounts");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (200):

```json
{
    "id": 6,
    "name": "Test Test",
    "email": "test@test.com",
    "address": "adress"
}
```
## Add new account

`POST api/accounts`

| Body parameter| Type | Status | Description |
| ------------- |:-------------:| -----:|----:|
| name          | string        | required    | Name of account
| email         | string        | required    | Email of account
| password      | string        | required    | Password of account

<!-- END_2aec2942df5caa3ceb291b37cb3f8441 -->

<!-- START_2e3bad94a1c50a2d03acc0ec870caefa -->

> Request:

```bash
curl -X POST "http://localhost/api/accounts" \
    -H "Content-Type: application/json" \
    -d '{"name":"OxUNk1IebJf6BswA","email":"0OPUxM69H1mS1tPS","password":"HirWRsyQK2IQ0Q9x","address":"z2mHzvKIRnUQmuIY","image":"fjTs7mtjUyEl9q6n"}'

```

```javascript
const url = new URL("http://localhost/api/accounts");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "OxUNk1IebJf6BswA",
    "email": "0OPUxM69H1mS1tPS",
    "password": "HirWRsyQK2IQ0Q9x",
    "address": "z2mHzvKIRnUQmuIY",
    "image": "fjTs7mtjUyEl9q6n"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (201):

```json
{
    "message": "Successfully registered!"
}
```
> Response (500):

```json
{
    "error": "Server error please try again"
}
```

### HTTP Request
`POST api/accounts`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name  | string  |  required  | Represents name of a account
    email | string  |  required  | Represents email of a account
    password | string |  required  | Represents password of a account
    address | string |  required  | Represents address of a account
    image | image |  required  | Represents an image id of a account

<!-- END_2e3bad94a1c50a2d03acc0ec870caefa -->

<!-- START_9b44b4cf3baf08caef7a0b0feb798b91 -->
## Get specific account info

> Request:

```bash
curl -X GET -G "http://localhost/api/accounts/{account}"
```

```javascript
const url = new URL("http://localhost/api/accounts/{account}");

    let params = {
            "id": "4",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (200):

```json
{
    "id": 6,
    "name": "Test Test",
    "email": "test@test.com",
    "address": "adress"
}
```
> Response (404):

```json
{
    "message": "Account not found"
}
```
> Response (500):

```json
{
    "error": "Server error, plase try again"
}
```

### HTTP Request
`GET api/accounts/{account}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    id |  required  | The id of the account

<!-- END_9b44b4cf3baf08caef7a0b0feb798b91 -->

<!-- START_09355645fc0ffe74ed6131e59d16b75b -->
## Update the authenticated user&#039;s account

> Request:

```bash
curl -X PUT "http://localhost/api/accounts/{account}" \
    -H "Content-Type: application/json" \
    -d '{"name":"QkEp6EtE7ZTcDCpI","address":"cvGT9doxYxhI6Tzf","image":"VivVZCIU8CnPWZf4"}'

```

```javascript
const url = new URL("http://localhost/api/accounts/{account}");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "QkEp6EtE7ZTcDCpI",
    "address": "cvGT9doxYxhI6Tzf",
    "image": "VivVZCIU8CnPWZf4"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (204) [No content]:


> Response (500):

```json
{
    "error": "Server error, plase try again"
}
```

### HTTP Request
`PUT api/accounts/{account}`

`PATCH api/accounts/{account}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | Represents name of a account
    address | string |  required  | Represents address of a account
    image | Formdata |  required  | Represents image file of a account

<!-- END_09355645fc0ffe74ed6131e59d16b75b -->

<!-- START_63ade56ead934b427331840fb76fdbae -->
## Deactivate authenticated user&#039;s account

> Request:

```bash
curl -X DELETE "http://localhost/api/accounts/{account}"
```

```javascript
const url = new URL("http://localhost/api/accounts/{account}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (204): [No content]

> Response (500):

```json
{
    "error": "Server error, plase try again"
}
```

### Products
`GET api/products`


<!-- END_63ade56ead934b427331840fb76fdbae -->

<!-- START_86e0ac5d4f8ce9853bc22fd08f2a0109 -->
## Get all authenticated user's products

| Query Parameter     | Type     | Status   | Description|
| ------------- |:-------------: | -----:   | :----------|
| perPage       | int  | optional|                Amount of products you want to get from server      |
| page          | int|optional   |   Page you get products from that page    |            |
| name | string       |    optional    |   Search product by name         |
| maxPrice|int|optional| Get products with maxPrice of :number|
| minPrice|int|optional| Get products with minPrice of :number|
| discount|boolean|optional| Get only products with discount |

> Request:

```bash
curl -X GET -G "http://localhost/api/products"
```

```javascript
const url = new URL("http://localhost/api/products");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (200):
```json
{
  "data": [
    {
      "id": 6,
      "name": "Thrust tastatura",
      "description": "Komp iz 2012",
      "brand": "Thrust",
      "storages": [
        {
          "type": "hangar",
          "address": "Hangar Luka",
          "quantity": 150,
          "unit": "pc."
        }
      ],
      "price": 12200,
      "discount": null,
      "categories": [
        {
          "id": 3,
          "name": "Hardware"
        }
      ],
      "images": [
        {
          "id": 6,
          "src": "images\/1553726063wilson3x3.jpeg"
        },
        {
          "id": 7,
          "src": "images\/1553726063images.jpeg"
        }
      ]
    }
],
total: 100,
currentPage: 1
}


```

> Response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/products`


<!-- END_86e0ac5d4f8ce9853bc22fd08f2a0109 -->

<!-- START_05b4383f00fd57c4828a831e7057e920 -->
## Store a newly created resource in storage.

> Request:

```bash
curl -X POST "http://localhost/api/products"
```

```javascript
const url = new URL("http://localhost/api/products");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/products`


<!-- END_05b4383f00fd57c4828a831e7057e920 -->

<!-- START_a285e63bc2d1a5b9428ae9aed745c779 -->
## Display the specified resource.

> Request:

```bash
curl -X GET -G "http://localhost/api/products/{product}"
```

```javascript
const url = new URL("http://localhost/api/products/{product}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/products/{product}`


<!-- END_a285e63bc2d1a5b9428ae9aed745c779 -->

<!-- START_b7842ce7893c09eb3c53713f82c2e12d -->
## Update the specified resource in storage.

> Request:

```bash
curl -X PUT "http://localhost/api/products/{product}"
```

```javascript
const url = new URL("http://localhost/api/products/{product}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT api/products/{product}`

`PATCH api/products/{product}`


<!-- END_b7842ce7893c09eb3c53713f82c2e12d -->

<!-- START_1d809ca5e8b10fa7fdc75d04506a55ea -->
## Remove the specified resource from storage.

> Request:

```bash
curl -X DELETE "http://localhost/api/products/{product}"
```

```javascript
const url = new URL("http://localhost/api/products/{product}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE api/products/{product}`


<!-- END_1d809ca5e8b10fa7fdc75d04506a55ea -->

<!-- START_109013899e0bc43247b0f00b67f889cf -->
## Get all categories for authenticated user. There are some default categories. Default per page is 50

@queryParam name string optional The name of the categories.

> Request:

```bash
curl -X GET -G "http://localhost/api/categories"
```

```javascript
const url = new URL("http://localhost/api/categories");

    let params = {
            "perPage": "11",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/categories`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    perPage |  optional  | int optional Total number of categories per page.

<!-- END_109013899e0bc43247b0f00b67f889cf -->

<!-- START_2335abbed7f782ea7d7dd6df9c738d74 -->
## Add a new category.

@bodyParam name string required Represents category name.

> Request:

```bash
curl -X POST "http://localhost/api/categories" \
    -H "Content-Type: application/json" \
    -d '{"subcategory_id":6}'

```

```javascript
const url = new URL("http://localhost/api/categories");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "subcategory_id": 6
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (201):

```json
{
    "message": "Successfully added new category"
}
```
> Response (500):

```json
{
    "error": "Server error, please try later."
}
```

### HTTP Request
`POST api/categories`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    subcategory_id | integer |  optional  | optional Represents category subcategory_id.

<!-- END_2335abbed7f782ea7d7dd6df9c738d74 -->

<!-- START_34925c1e31e7ecc53f8f52c8b1e91d44 -->
## Get the specified category details.

> Request:

```bash
curl -X GET -G "http://localhost/api/categories/{category}"
```

```javascript
const url = new URL("http://localhost/api/categories/{category}");

    let params = {
            "id": "x4beX0AeWi7Tcsdq",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (200):

```json
{}
```
> Response (404):

```json
{
    "error": "Category not found"
}
```

### HTTP Request
`GET api/categories/{category}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    id |  optional  | int optional Represents category id.

<!-- END_34925c1e31e7ecc53f8f52c8b1e91d44 -->

<!-- START_549109b98c9f25ebff47fb4dc23423b6 -->
## Update the specified category.

@bodyParam name string required Represents category name.

> Request:

```bash
curl -X PUT "http://localhost/api/categories/{category}" \
    -H "Content-Type: application/json" \
    -d '{"subcategory_id":1}'

```

```javascript
const url = new URL("http://localhost/api/categories/{category}");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "subcategory_id": 1
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (204):

```json
[]
```
> Response (404):

```json
{
    "error": "Category not found"
}
```
> Response (500):

```json
{
    "error": "Server error, please try later."
}
```

### HTTP Request
`PUT api/categories/{category}`

`PATCH api/categories/{category}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    subcategory_id | integer |  optional  | optional Represents category subcategory_id.

<!-- END_549109b98c9f25ebff47fb4dc23423b6 -->

<!-- START_7513823f87b59040507bd5ab26f9ceb5 -->
## Remove the specific category.

> Request:

```bash
curl -X DELETE "http://localhost/api/categories/{category}"
```

```javascript
const url = new URL("http://localhost/api/categories/{category}");

    let params = {
            "int": "BAwMjmIM4Vn9lbkc",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (204):

```json
[]
```
> Response (404):

```json
{
    "error": "Category not found"
}
```

### HTTP Request
`DELETE api/categories/{category}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    int |  optional  | id integer required Represents category id.

<!-- END_7513823f87b59040507bd5ab26f9ceb5 -->

<!-- START_49314ee162f7e839596684af0fed40e9 -->
## Get all brands

> Request:

```bash
curl -X GET -G "http://localhost/api/brands" \
    -H "Content-Type: application/json" \
    -d '{"name":"eewjdT0n2z6bMKBx","perPage":15,"page":2}'

```

```javascript
const url = new URL("http://localhost/api/brands");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "eewjdT0n2z6bMKBx",
    "perPage": 15,
    "page": 2
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (200):

```json
{
    "data": [
        {
            "id": 1,
            "name": "Brand name"
        }
    ],
    "total": 1,
    "currentPage": 1
}
```

### HTTP Request
`GET api/brands`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  optional  | optional The name of the brand.
    perPage | integer |  optional  | optional Total number of brands per page.
    page | integer |  optional  | Parameter page represents that page you want to see brands.

<!-- END_49314ee162f7e839596684af0fed40e9 -->

<!-- START_745f1520c22769b1767899facf665d2b -->
## Add a new brand.

> Request:

```bash
curl -X POST "http://localhost/api/brands" \
    -H "Content-Type: application/json" \
    -d '{"name":"d8piTKrFsYWPK6c5"}'

```

```javascript
const url = new URL("http://localhost/api/brands");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "d8piTKrFsYWPK6c5"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (201):

```json
{
    "message": "Successfully added new brand."
}
```
> Response (500):

```json
{
    "error": "Server error please try again."
}
```

### HTTP Request
`POST api/brands`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | Represents name of brand

<!-- END_745f1520c22769b1767899facf665d2b -->

<!-- START_d6817829cfe616a73d4ac4da93453508 -->
## Get the specified brand.

> Request:

```bash
curl -X GET -G "http://localhost/api/brands/{brand}"
```

```javascript
const url = new URL("http://localhost/api/brands/{brand}");

    let params = {
            "id": "JGTJIBCeBKGwJ7Vl",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (200):

```json
{
    "id": 1,
    "name": "Brand name"
}
```
> Response (404):

```json
{
    "error": "Brand not found"
}
```

### HTTP Request
`GET api/brands/{brand}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    id |  required  | The id of the brand

<!-- END_d6817829cfe616a73d4ac4da93453508 -->

<!-- START_042c9bfce86a99d5c778f8e02c29a5d7 -->
## Update a specific brand.

> Request:

```bash
curl -X PUT "http://localhost/api/brands/{brand}" \
    -H "Content-Type: application/json" \
    -d '{"name":"gV46qJAagsyzXKTt"}'

```

```javascript
const url = new URL("http://localhost/api/brands/{brand}");

    let params = {
            "id": "tq42O5auvwmeSNsr",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "gV46qJAagsyzXKTt"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (204):

```json
[]
```
> Response (404):

```json
{
    "error": "Brand not found"
}
```
> Response (500):

```json
{
    "error": "Server error please try again."
}
```

### HTTP Request
`PUT api/brands/{brand}`

`PATCH api/brands/{brand}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | Represents name of brand
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    id |  required  | The id of the brand

<!-- END_042c9bfce86a99d5c778f8e02c29a5d7 -->

<!-- START_6bc624c1de327f8a14d11df082f18630 -->
## Delete a specific brand.

> Request:

```bash
curl -X DELETE "http://localhost/api/brands/{brand}"
```

```javascript
const url = new URL("http://localhost/api/brands/{brand}");

    let params = {
            "id": "CFHNiu2wcTIkpk8N",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (204):

```json
[]
```
> Response (404):

```json
{
    "error": "Brand not found"
}
```
> Response (500):

```json
{
    "error": "Server error please try again."
}
```

### HTTP Request
`DELETE api/brands/{brand}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    id |  required  | The id of the brand

<!-- END_6bc624c1de327f8a14d11df082f18630 -->

<!-- START_007018a8a9f15c2d47fcb105431ffeee -->
## Display a listing of the resource.

> Request:

```bash
curl -X GET -G "http://localhost/api/groups"
```

```javascript
const url = new URL("http://localhost/api/groups");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/groups`


<!-- END_007018a8a9f15c2d47fcb105431ffeee -->

<!-- START_15c22564ad248f952405021410fd1d25 -->
## Store a newly created resource in storage.

> Request:

```bash
curl -X POST "http://localhost/api/groups"
```

```javascript
const url = new URL("http://localhost/api/groups");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/groups`


<!-- END_15c22564ad248f952405021410fd1d25 -->

<!-- START_a209a43173c7c4aaf7ab070d77fb7f0c -->
## Display the specified resource.

> Request:

```bash
curl -X GET -G "http://localhost/api/groups/{group}"
```

```javascript
const url = new URL("http://localhost/api/groups/{group}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/groups/{group}`


<!-- END_a209a43173c7c4aaf7ab070d77fb7f0c -->

<!-- START_5b84408c838201930093112a7621935c -->
## Update the specified resource in storage.

> Request:

```bash
curl -X PUT "http://localhost/api/groups/{group}"
```

```javascript
const url = new URL("http://localhost/api/groups/{group}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT api/groups/{group}`

`PATCH api/groups/{group}`


<!-- END_5b84408c838201930093112a7621935c -->

<!-- START_bd4f731f3f84c755053406b8971eba1f -->
## Remove the specified resource from storage.

> Request:

```bash
curl -X DELETE "http://localhost/api/groups/{group}"
```

```javascript
const url = new URL("http://localhost/api/groups/{group}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE api/groups/{group}`


<!-- END_bd4f731f3f84c755053406b8971eba1f -->

<!-- START_f42e87598c8353944d88aa8de3b294a1 -->
## Display a listing of the resource.

> Request:

```bash
curl -X GET -G "http://localhost/api/vendors"
```

```javascript
const url = new URL("http://localhost/api/vendors");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/vendors`


<!-- END_f42e87598c8353944d88aa8de3b294a1 -->

<!-- START_1bde2ae91edc93f7bbabeaac8cf40f10 -->
## Store a newly created resource in storage.

> Request:

```bash
curl -X POST "http://localhost/api/vendors"
```

```javascript
const url = new URL("http://localhost/api/vendors");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/vendors`


<!-- END_1bde2ae91edc93f7bbabeaac8cf40f10 -->

<!-- START_36f5888fe8bce09ddad954f2e83f3c7e -->
## Display the specified resource.

> Request:

```bash
curl -X GET -G "http://localhost/api/vendors/{vendor}"
```

```javascript
const url = new URL("http://localhost/api/vendors/{vendor}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/vendors/{vendor}`


<!-- END_36f5888fe8bce09ddad954f2e83f3c7e -->

<!-- START_926d9ec82336bf48eb63182a4f95ce9c -->
## Update the specified resource in storage.

> Request:

```bash
curl -X PUT "http://localhost/api/vendors/{vendor}"
```

```javascript
const url = new URL("http://localhost/api/vendors/{vendor}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT api/vendors/{vendor}`

`PATCH api/vendors/{vendor}`


<!-- END_926d9ec82336bf48eb63182a4f95ce9c -->

<!-- START_705d08695c4e2d9e4ba3f3f548b7d82c -->
## Remove the specified resource from storage.

> Request:

```bash
curl -X DELETE "http://localhost/api/vendors/{vendor}"
```

```javascript
const url = new URL("http://localhost/api/vendors/{vendor}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE api/vendors/{vendor}`


<!-- END_705d08695c4e2d9e4ba3f3f548b7d82c -->

<!-- START_760ddc8b4bee8ffc1fd3ebb7622b2f20 -->
## Display a listing of the resource.

> Request:

```bash
curl -X GET -G "http://localhost/api/storage-types"
```

```javascript
const url = new URL("http://localhost/api/storage-types");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/storage-types`


<!-- END_760ddc8b4bee8ffc1fd3ebb7622b2f20 -->

<!-- START_750e283de19d4b526b72b8afc4c0cb2b -->
## Store a newly created resource in storage.

> Request:

```bash
curl -X POST "http://localhost/api/storage-types"
```

```javascript
const url = new URL("http://localhost/api/storage-types");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/storage-types`


<!-- END_750e283de19d4b526b72b8afc4c0cb2b -->

<!-- START_019c7f99fdb64a7addf2d3981cd93ae7 -->
## Display the specified resource.

> Request:

```bash
curl -X GET -G "http://localhost/api/storage-types/{storage_type}"
```

```javascript
const url = new URL("http://localhost/api/storage-types/{storage_type}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/storage-types/{storage_type}`


<!-- END_019c7f99fdb64a7addf2d3981cd93ae7 -->

<!-- START_a69bd4475517734329823d55eb05ecfb -->
## Update the specified resource in storage.

> Request:

```bash
curl -X PUT "http://localhost/api/storage-types/{storage_type}"
```

```javascript
const url = new URL("http://localhost/api/storage-types/{storage_type}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT api/storage-types/{storage_type}`

`PATCH api/storage-types/{storage_type}`


<!-- END_a69bd4475517734329823d55eb05ecfb -->

<!-- START_205ab34f2b4440902aa74991e6ddf614 -->
## Remove the specified resource from storage.

> Request:

```bash
curl -X DELETE "http://localhost/api/storage-types/{storage_type}"
```

```javascript
const url = new URL("http://localhost/api/storage-types/{storage_type}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE api/storage-types/{storage_type}`


<!-- END_205ab34f2b4440902aa74991e6ddf614 -->

<!-- START_137649fa3a408a8214f5ffe417b31b9f -->
## Display a listing of the resource.

> Request:

```bash
curl -X GET -G "http://localhost/api/storages"
```

```javascript
const url = new URL("http://localhost/api/storages");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/storages`


<!-- END_137649fa3a408a8214f5ffe417b31b9f -->

<!-- START_175ab5a35abe60c350ff0146d72cdb99 -->
## Store a newly created resource in storage.

> Request:

```bash
curl -X POST "http://localhost/api/storages"
```

```javascript
const url = new URL("http://localhost/api/storages");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/storages`


<!-- END_175ab5a35abe60c350ff0146d72cdb99 -->

<!-- START_31d9675b6a7fb6c8cb8f26d7a0e15382 -->
## Display the specified resource.

> Request:

```bash
curl -X GET -G "http://localhost/api/storages/{storage}"
```

```javascript
const url = new URL("http://localhost/api/storages/{storage}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/storages/{storage}`


<!-- END_31d9675b6a7fb6c8cb8f26d7a0e15382 -->

<!-- START_47c3f7445d03fbe1aa5a64ea0a9583cb -->
## Update the specified resource in storage.

> Request:

```bash
curl -X PUT "http://localhost/api/storages/{storage}"
```

```javascript
const url = new URL("http://localhost/api/storages/{storage}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT api/storages/{storage}`

`PATCH api/storages/{storage}`


<!-- END_47c3f7445d03fbe1aa5a64ea0a9583cb -->

<!-- START_bf29e729fd3b942aba414903f6fd00e0 -->
## Remove the specified resource from storage.

> Request:

```bash
curl -X DELETE "http://localhost/api/storages/{storage}"
```

```javascript
const url = new URL("http://localhost/api/storages/{storage}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE api/storages/{storage}`


<!-- END_bf29e729fd3b942aba414903f6fd00e0 -->

<!-- START_d896f1a10df68fd887f4031d08963037 -->
## Display a listing of the resource.

> Request:

```bash
curl -X GET -G "http://localhost/api/units"
```

```javascript
const url = new URL("http://localhost/api/units");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/units`


<!-- END_d896f1a10df68fd887f4031d08963037 -->

<!-- START_b6f115cedfa1487a140a1fd740e00ae7 -->
## Store a newly created resource in storage.

> Request:

```bash
curl -X POST "http://localhost/api/units"
```

```javascript
const url = new URL("http://localhost/api/units");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/units`


<!-- END_b6f115cedfa1487a140a1fd740e00ae7 -->

<!-- START_05fc11fb040188ec1ccd104edfd5c058 -->
## Display the specified resource.

> Request:

```bash
curl -X GET -G "http://localhost/api/units/{unit}"
```

```javascript
const url = new URL("http://localhost/api/units/{unit}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (429):

```json
{
    "message": "Too Many Attempts.",
    "exception": "Illuminate\\Http\\Exceptions\\ThrottleRequestsException",
    "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php",
    "line": 124,
    "trace": [
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php",
            "line": 53,
            "function": "buildException",
            "class": "Illuminate\\Routing\\Middleware\\ThrottleRequests",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Routing\\Middleware\\ThrottleRequests",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 104,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 684,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 659,
            "function": "runRouteWithinStack",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 625,
            "function": "runRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 614,
            "function": "dispatchToRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 176,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 30,
            "function": "Illuminate\\Foundation\\Http\\{closure}",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/barryvdh\/laravel-cors\/src\/HandleCors.php",
            "line": 36,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Barryvdh\\Cors\\HandleCors",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/fideloper\/proxy\/src\/TrustProxies.php",
            "line": 57,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Fideloper\\Proxy\\TrustProxies",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 31,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 31,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php",
            "line": 27,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/CheckForMaintenanceMode.php",
            "line": 62,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 104,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 151,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 116,
            "function": "sendRequestThroughRouter",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseStrategies\/ResponseCallStrategy.php",
            "line": 276,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseStrategies\/ResponseCallStrategy.php",
            "line": 260,
            "function": "callLaravelRoute",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseStrategies\/ResponseCallStrategy.php",
            "line": 36,
            "function": "makeApiCall",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseResolver.php",
            "line": 49,
            "function": "__invoke",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseResolver.php",
            "line": 68,
            "function": "resolve",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseResolver",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/Generator.php",
            "line": 57,
            "function": "getResponse",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseResolver",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Commands\/GenerateDocumentation.php",
            "line": 201,
            "function": "processRoute",
            "class": "Mpociot\\ApiDoc\\Tools\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Commands\/GenerateDocumentation.php",
            "line": 59,
            "function": "processRoutes",
            "class": "Mpociot\\ApiDoc\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "function": "handle",
            "class": "Mpociot\\ApiDoc\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 29,
            "function": "call_user_func_array"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 87,
            "function": "Illuminate\\Container\\{closure}",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 31,
            "function": "callBoundMethod",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
            "line": 572,
            "function": "call",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 183,
            "function": "call",
            "class": "Illuminate\\Container\\Container",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Command\/Command.php",
            "line": 255,
            "function": "execute",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 170,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Command\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Application.php",
            "line": 908,
            "function": "run",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Application.php",
            "line": 269,
            "function": "doRunCommand",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Application.php",
            "line": 145,
            "function": "doRun",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php",
            "line": 89,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php",
            "line": 122,
            "function": "run",
            "class": "Illuminate\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/artisan",
            "line": 37,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Console\\Kernel",
            "type": "->"
        }
    ]
}
```

### HTTP Request
`GET api/units/{unit}`


<!-- END_05fc11fb040188ec1ccd104edfd5c058 -->

<!-- START_f265b266d78261c2d2c0eb72752b8cd1 -->
## Update the specified resource in storage.

> Request:

```bash
curl -X PUT "http://localhost/api/units/{unit}"
```

```javascript
const url = new URL("http://localhost/api/units/{unit}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT api/units/{unit}`

`PATCH api/units/{unit}`


<!-- END_f265b266d78261c2d2c0eb72752b8cd1 -->

<!-- START_5adb3e8626c2c401efe01fbdcbcf16d3 -->
## Remove the specified resource from storage.

> Request:

```bash
curl -X DELETE "http://localhost/api/units/{unit}"
```

```javascript
const url = new URL("http://localhost/api/units/{unit}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE api/units/{unit}`


<!-- END_5adb3e8626c2c401efe01fbdcbcf16d3 -->

<!-- START_7753274c573ffb24cc6dbb6c94bbf532 -->
## Display a listing of the resource.

> Request:

```bash
curl -X GET -G "http://localhost/api/product-types"
```

```javascript
const url = new URL("http://localhost/api/product-types");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (429):

```json
{
    "message": "Too Many Attempts.",
    "exception": "Illuminate\\Http\\Exceptions\\ThrottleRequestsException",
    "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php",
    "line": 124,
    "trace": [
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php",
            "line": 53,
            "function": "buildException",
            "class": "Illuminate\\Routing\\Middleware\\ThrottleRequests",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Routing\\Middleware\\ThrottleRequests",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 104,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 684,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 659,
            "function": "runRouteWithinStack",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 625,
            "function": "runRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 614,
            "function": "dispatchToRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 176,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 30,
            "function": "Illuminate\\Foundation\\Http\\{closure}",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/barryvdh\/laravel-cors\/src\/HandleCors.php",
            "line": 36,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Barryvdh\\Cors\\HandleCors",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/fideloper\/proxy\/src\/TrustProxies.php",
            "line": 57,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Fideloper\\Proxy\\TrustProxies",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 31,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 31,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php",
            "line": 27,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/CheckForMaintenanceMode.php",
            "line": 62,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 104,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 151,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 116,
            "function": "sendRequestThroughRouter",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseStrategies\/ResponseCallStrategy.php",
            "line": 276,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseStrategies\/ResponseCallStrategy.php",
            "line": 260,
            "function": "callLaravelRoute",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseStrategies\/ResponseCallStrategy.php",
            "line": 36,
            "function": "makeApiCall",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseResolver.php",
            "line": 49,
            "function": "__invoke",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseResolver.php",
            "line": 68,
            "function": "resolve",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseResolver",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/Generator.php",
            "line": 57,
            "function": "getResponse",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseResolver",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Commands\/GenerateDocumentation.php",
            "line": 201,
            "function": "processRoute",
            "class": "Mpociot\\ApiDoc\\Tools\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Commands\/GenerateDocumentation.php",
            "line": 59,
            "function": "processRoutes",
            "class": "Mpociot\\ApiDoc\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "function": "handle",
            "class": "Mpociot\\ApiDoc\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 29,
            "function": "call_user_func_array"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 87,
            "function": "Illuminate\\Container\\{closure}",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 31,
            "function": "callBoundMethod",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
            "line": 572,
            "function": "call",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 183,
            "function": "call",
            "class": "Illuminate\\Container\\Container",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Command\/Command.php",
            "line": 255,
            "function": "execute",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 170,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Command\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Application.php",
            "line": 908,
            "function": "run",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Application.php",
            "line": 269,
            "function": "doRunCommand",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Application.php",
            "line": 145,
            "function": "doRun",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php",
            "line": 89,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php",
            "line": 122,
            "function": "run",
            "class": "Illuminate\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/artisan",
            "line": 37,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Console\\Kernel",
            "type": "->"
        }
    ]
}
```

### HTTP Request
`GET api/product-types`


<!-- END_7753274c573ffb24cc6dbb6c94bbf532 -->

<!-- START_b4c8702f464000f4178d274571482d1d -->
## Store a newly created resource in storage.

> Request:

```bash
curl -X POST "http://localhost/api/product-types"
```

```javascript
const url = new URL("http://localhost/api/product-types");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/product-types`


<!-- END_b4c8702f464000f4178d274571482d1d -->

<!-- START_02261322b1f47ce0bde3b89aaea24816 -->
## Display the specified resource.

> Request:

```bash
curl -X GET -G "http://localhost/api/product-types/{product_type}"
```

```javascript
const url = new URL("http://localhost/api/product-types/{product_type}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (429):

```json
{
    "message": "Too Many Attempts.",
    "exception": "Illuminate\\Http\\Exceptions\\ThrottleRequestsException",
    "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php",
    "line": 124,
    "trace": [
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php",
            "line": 53,
            "function": "buildException",
            "class": "Illuminate\\Routing\\Middleware\\ThrottleRequests",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Routing\\Middleware\\ThrottleRequests",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 104,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 684,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 659,
            "function": "runRouteWithinStack",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 625,
            "function": "runRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 614,
            "function": "dispatchToRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 176,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 30,
            "function": "Illuminate\\Foundation\\Http\\{closure}",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/barryvdh\/laravel-cors\/src\/HandleCors.php",
            "line": 36,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Barryvdh\\Cors\\HandleCors",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/fideloper\/proxy\/src\/TrustProxies.php",
            "line": 57,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Fideloper\\Proxy\\TrustProxies",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 31,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 31,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php",
            "line": 27,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/CheckForMaintenanceMode.php",
            "line": 62,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 104,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 151,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 116,
            "function": "sendRequestThroughRouter",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseStrategies\/ResponseCallStrategy.php",
            "line": 276,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseStrategies\/ResponseCallStrategy.php",
            "line": 260,
            "function": "callLaravelRoute",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseStrategies\/ResponseCallStrategy.php",
            "line": 36,
            "function": "makeApiCall",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseResolver.php",
            "line": 49,
            "function": "__invoke",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseResolver.php",
            "line": 68,
            "function": "resolve",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseResolver",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/Generator.php",
            "line": 57,
            "function": "getResponse",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseResolver",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Commands\/GenerateDocumentation.php",
            "line": 201,
            "function": "processRoute",
            "class": "Mpociot\\ApiDoc\\Tools\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Commands\/GenerateDocumentation.php",
            "line": 59,
            "function": "processRoutes",
            "class": "Mpociot\\ApiDoc\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "function": "handle",
            "class": "Mpociot\\ApiDoc\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 29,
            "function": "call_user_func_array"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 87,
            "function": "Illuminate\\Container\\{closure}",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 31,
            "function": "callBoundMethod",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
            "line": 572,
            "function": "call",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 183,
            "function": "call",
            "class": "Illuminate\\Container\\Container",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Command\/Command.php",
            "line": 255,
            "function": "execute",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 170,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Command\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Application.php",
            "line": 908,
            "function": "run",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Application.php",
            "line": 269,
            "function": "doRunCommand",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Application.php",
            "line": 145,
            "function": "doRun",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php",
            "line": 89,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php",
            "line": 122,
            "function": "run",
            "class": "Illuminate\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/artisan",
            "line": 37,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Console\\Kernel",
            "type": "->"
        }
    ]
}
```

### HTTP Request
`GET api/product-types/{product_type}`


<!-- END_02261322b1f47ce0bde3b89aaea24816 -->

<!-- START_096e52d4821c599219994b2464d08084 -->
## Update the specified resource in storage.

> Request:

```bash
curl -X PUT "http://localhost/api/product-types/{product_type}"
```

```javascript
const url = new URL("http://localhost/api/product-types/{product_type}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT api/product-types/{product_type}`

`PATCH api/product-types/{product_type}`


<!-- END_096e52d4821c599219994b2464d08084 -->

<!-- START_bd0af4fe0131aa04aa66c725aec9254d -->
## Remove the specified resource from storage.

> Request:

```bash
curl -X DELETE "http://localhost/api/product-types/{product_type}"
```

```javascript
const url = new URL("http://localhost/api/product-types/{product_type}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE api/product-types/{product_type}`


<!-- END_bd0af4fe0131aa04aa66c725aec9254d -->

<!-- START_c467ea136be82b3e0e654ddf489f3af8 -->
## Change account password

> Request:

```bash
curl -X PATCH "http://localhost/api/accounts"
```

```javascript
const url = new URL("http://localhost/api/accounts");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (204):

```json
[]
```
> Response (500):

```json
{
    "error": "Server error, plase try again"
}
```

### HTTP Request
`PATCH api/accounts`


<!-- END_c467ea136be82b3e0e654ddf489f3af8 -->

<!-- START_e6481a5e3fa839aa201af03efcef83f3 -->
## api/products/{id}/images
> Request:

```bash
curl -X POST "http://localhost/api/products/{id}/images"
```

```javascript
const url = new URL("http://localhost/api/products/{id}/images");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/products/{id}/images`


<!-- END_e6481a5e3fa839aa201af03efcef83f3 -->

<!-- START_912f045a501f22ee6e8bc68ade14176a -->
## api/products/{id}/images
> Request:

```bash
curl -X DELETE "http://localhost/api/products/{id}/images"
```

```javascript
const url = new URL("http://localhost/api/products/{id}/images");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE api/products/{id}/images`


<!-- END_912f045a501f22ee6e8bc68ade14176a -->

<!-- START_034a4bb49fe885f30b8c3de3ade87240 -->
## api/storages/{id}/images
> Request:

```bash
curl -X POST "http://localhost/api/storages/{id}/images"
```

```javascript
const url = new URL("http://localhost/api/storages/{id}/images");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/storages/{id}/images`


<!-- END_034a4bb49fe885f30b8c3de3ade87240 -->

<!-- START_4a3378775d76cb75443bd1ca0f7892ba -->
## api/storages/{id}/images
> Request:

```bash
curl -X DELETE "http://localhost/api/storages/{id}/images"
```

```javascript
const url = new URL("http://localhost/api/storages/{id}/images");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE api/storages/{id}/images`


<!-- END_4a3378775d76cb75443bd1ca0f7892ba -->

<!-- START_460d5318e156e0f30c9ae7d7a10424c2 -->
## api/storages/{id}/products
> Request:

```bash
curl -X POST "http://localhost/api/storages/{id}/products"
```

```javascript
const url = new URL("http://localhost/api/storages/{id}/products");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/storages/{id}/products`


<!-- END_460d5318e156e0f30c9ae7d7a10424c2 -->

<!-- START_20b8def8d8f10c8529df174085988ed8 -->
## api/storages/{id}/products
> Request:

```bash
curl -X DELETE "http://localhost/api/storages/{id}/products"
```

```javascript
const url = new URL("http://localhost/api/storages/{id}/products");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE api/storages/{id}/products`


<!-- END_20b8def8d8f10c8529df174085988ed8 -->

<!-- START_af74a430664cdf1c2ce7f7d53b49362d -->
## api/prices/products/{id}
> Request:

```bash
curl -X POST "http://localhost/api/prices/products/{id}"
```

```javascript
const url = new URL("http://localhost/api/prices/products/{id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/prices/products/{id}`


<!-- END_af74a430664cdf1c2ce7f7d53b49362d -->

<!-- START_284605ef8e391dd894674a5c5ff204a8 -->
## api/prices/products/{id}
> Request:

```bash
curl -X PUT "http://localhost/api/prices/products/{id}"
```

```javascript
const url = new URL("http://localhost/api/prices/products/{id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT api/prices/products/{id}`


<!-- END_284605ef8e391dd894674a5c5ff204a8 -->

<!-- START_9b07d7cfebb55bfacf8bfeba68577d4c -->
## Add a discount to specific product.

@queryParam id int required Represents an id of a product

> Request:

```bash
curl -X POST "http://localhost/api/discounts/products/{id}" \
    -H "Content-Type: application/json" \
    -d '{"amount":4}'

```

```javascript
const url = new URL("http://localhost/api/discounts/products/{id}");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "amount": 4
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (201):

```json
{
    "message": "Successfully added new discount to product"
}
```
> Response (404):

```json
{
    "error": "Product not found."
}
```
> Response (409):

```json
{
    "error": "Product doesn't have initial price."
}
```
> Response (500):

```json
{
    "error": "Server error, please try later."
}
```

### HTTP Request
`POST api/discounts/products/{id}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    amount | integer |  required  | Represents an amount of discount

<!-- END_9b07d7cfebb55bfacf8bfeba68577d4c -->

<!-- START_8374feca8d7920a5179b5895b8af14df -->
## Update a discount to specific product.

@queryParam id int required Represents an id of a product

> Request:

```bash
curl -X PUT "http://localhost/api/discounts/products/{id}" \
    -H "Content-Type: application/json" \
    -d '{"amount":3}'

```

```javascript
const url = new URL("http://localhost/api/discounts/products/{id}");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "amount": 3
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (204):

```json
[]
```
> Response (404):

```json
{
    "error": "Product not found."
}
```
> Response (409):

```json
{
    "error": "Product doesn't have initial price."
}
```
> Response (409):

```json
{
    "error": "Discount must be lower than current price."
}
```
> Response (500):

```json
{
    "error": "Server error, please try later."
}
```

### HTTP Request
`PUT api/discounts/products/{id}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    amount | integer |  required  | Represents an amount of discount

<!-- END_8374feca8d7920a5179b5895b8af14df -->

<!-- START_61739f3220a224b34228600649230ad1 -->
## api/logout
> Request:

```bash
curl -X POST "http://localhost/api/logout"
```

```javascript
const url = new URL("http://localhost/api/logout");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/logout`


<!-- END_61739f3220a224b34228600649230ad1 -->

<!-- START_c3fa189a6c95ca36ad6ac4791a873d23 -->
## api/login
> Request:

```bash
curl -X POST "http://localhost/api/login"
```

```javascript
const url = new URL("http://localhost/api/login");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/login`


<!-- END_c3fa189a6c95ca36ad6ac4791a873d23 -->

<!-- START_d7b7952e7fdddc07c978c9bdaf757acf -->
## Add new account

> Request:

```bash
curl -X POST "http://localhost/api/register" \
    -H "Content-Type: application/json" \
    -d '{"name":"VoIjSfXlT21sQuIo","email":"9fIdcLTyl0lceI2J","password":"WPfJKh0vUyuT8ErL","address":"znpXzj1hAyt3LOAs","image":"KPU4grXTRfItKGPb"}'

```

```javascript
const url = new URL("http://localhost/api/register");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "VoIjSfXlT21sQuIo",
    "email": "9fIdcLTyl0lceI2J",
    "password": "WPfJKh0vUyuT8ErL",
    "address": "znpXzj1hAyt3LOAs",
    "image": "KPU4grXTRfItKGPb"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (201):

```json
{
    "message": "Successfully registered!"
}
```
> Response (500):

```json
{
    "error": "Server error please try again"
}
```

### HTTP Request
`POST api/register`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | Represents name of a account
    email | string |  required  | Represents email of a account
    password | string |  required  | Represents password of a account
    address | string |  required  | Represents address of a account
    image | image |  required  | Represents an image id of a account

<!-- END_d7b7952e7fdddc07c978c9bdaf757acf -->

<!-- START_fa16a3c7fbba797e245ef0e886cb06d2 -->
## Handle the incoming request.

> Request:

```bash
curl -X GET -G "http://localhost/api/verification/{token}"
```

```javascript
const url = new URL("http://localhost/api/verification/{token}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Response (429):

```json
{
    "message": "Too Many Attempts.",
    "exception": "Illuminate\\Http\\Exceptions\\ThrottleRequestsException",
    "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php",
    "line": 124,
    "trace": [
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php",
            "line": 53,
            "function": "buildException",
            "class": "Illuminate\\Routing\\Middleware\\ThrottleRequests",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Routing\\Middleware\\ThrottleRequests",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 104,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 684,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 659,
            "function": "runRouteWithinStack",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 625,
            "function": "runRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
            "line": 614,
            "function": "dispatchToRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 176,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 30,
            "function": "Illuminate\\Foundation\\Http\\{closure}",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/barryvdh\/laravel-cors\/src\/HandleCors.php",
            "line": 36,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Barryvdh\\Cors\\HandleCors",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/fideloper\/proxy\/src\/TrustProxies.php",
            "line": 57,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Fideloper\\Proxy\\TrustProxies",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 31,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
            "line": 31,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php",
            "line": 27,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/CheckForMaintenanceMode.php",
            "line": 62,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 163,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
            "line": 104,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 151,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
            "line": 116,
            "function": "sendRequestThroughRouter",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseStrategies\/ResponseCallStrategy.php",
            "line": 276,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseStrategies\/ResponseCallStrategy.php",
            "line": 260,
            "function": "callLaravelRoute",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseStrategies\/ResponseCallStrategy.php",
            "line": 36,
            "function": "makeApiCall",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseResolver.php",
            "line": 49,
            "function": "__invoke",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/ResponseResolver.php",
            "line": 68,
            "function": "resolve",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseResolver",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Tools\/Generator.php",
            "line": 57,
            "function": "getResponse",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseResolver",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Commands\/GenerateDocumentation.php",
            "line": 201,
            "function": "processRoute",
            "class": "Mpociot\\ApiDoc\\Tools\\Generator",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/mpociot\/laravel-apidoc-generator\/src\/Commands\/GenerateDocumentation.php",
            "line": 59,
            "function": "processRoutes",
            "class": "Mpociot\\ApiDoc\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "function": "handle",
            "class": "Mpociot\\ApiDoc\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 29,
            "function": "call_user_func_array"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 87,
            "function": "Illuminate\\Container\\{closure}",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/BoundMethod.php",
            "line": 31,
            "function": "callBoundMethod",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
            "line": 572,
            "function": "call",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 183,
            "function": "call",
            "class": "Illuminate\\Container\\Container",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Command\/Command.php",
            "line": 255,
            "function": "execute",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Command.php",
            "line": 170,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Command\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Application.php",
            "line": 908,
            "function": "run",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Application.php",
            "line": 269,
            "function": "doRunCommand",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/symfony\/console\/Application.php",
            "line": 145,
            "function": "doRun",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Console\/Application.php",
            "line": 89,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Console\/Kernel.php",
            "line": 122,
            "function": "run",
            "class": "Illuminate\\Console\\Application",
            "type": "->"
        },
        {
            "file": "\/home\/cerealkiller\/public_html\/VshopperAPI\/artisan",
            "line": 37,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Console\\Kernel",
            "type": "->"
        }
    ]
}
```

### HTTP Request
`GET api/verification/{token}`


<!-- END_fa16a3c7fbba797e245ef0e886cb06d2 -->


