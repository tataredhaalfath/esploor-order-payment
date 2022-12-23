## Getting Started

## Installation
```bash
  $ composer install
  $ php artisan serve
```

## Setup ENV
```exampe
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=order_payment_database
  DB_USERNAME=root
  DB_PASSWORD=

  MIDTRANS_SERVER_KEY={your-midtrans-server-key}
  MIDTRANS_PRODUCTION=false
  MIDTRANS_3DS=true

  SERVICE_COURSE_URL=http://localhost:8000/
```
## Database Migration
```bash
  $ php artisan migrate
```

## Description
  This sevice will handle order and payment flow, the payment method already integrated with Midtrans payment gateway.

  This service running on laravel framework. Laravel is a web application framework with expressive, elegant syntax.

## API Documentation
- you can see the API Documentation in the api-docs.rest file

## API Contract

- [Create new order](#create-new-order)
- [Get Order](#get-order)
- [Webhook](#webhook)


### Create New Order

### Description
This api for create new order

### Method
`POST`

### URL
```diff
{URL_API}/api/orders
```

### Body
```diff
{
  "course":{
    "id":1,
    "name":"Kelas express",
    "thumbnail":"www.image.test",
    "price":250000,
    "level":"advance"
  },

  "user":{
    "id":5,
    "name":"fath",
    "email":"fath@gmail.com"
  }
}
```
### Response
```diff
{
    "status": "success",
    "data": {
        "user_id": 5,
        "course_id": 1,
        "updated_at": "2022-12-23 04:12:45",
        "created_at": "2022-12-23 04:12:43",
        "id": 3,
        "snap_url": "https://app.sandbox.midtrans.com/snap/v3/redirection/eba56350-6d14-4c26-b170-afd742189ba5",
        "metadata": {
            "course_id": 1,
            "course_price": 250000,
            "course_name": "Kelas express",
            "course_thumbnail": "www.image.test",
            "level": "advance"
        }
    }
}
```
<br>
<br>

---

### Get Order

### Description
This api for get all order data

### Method
`GET`

### URL
```diff
{URL_API}/api/orders/{user_id}
```

### Paras
```diff
user_id = [user_id](optional)
```

### Response
```diff
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "status": "success",
            "user_id": 1,
            "course_id": 1,
            "snap_url": "https://app.sandbox.midtrans.com/snap/v3/redirection/67ee2afa-a351-4547-9ee6-c8ca4b9fb845",
            "metadata": {
                "course_id": 1,
                "course_price": 250000,
                "course_name": "Kelas Laravel oke",
                "course_thumbnail": null,
                "level": "advance"
            },
            "created_at": "2022-12-22 13:12:33",
            "updated_at": "2022-12-22 13:12:43"
        },
        {
            "id": 2,
            "status": "pending",
            "user_id": 1,
            "course_id": 1,
            "snap_url": "https://app.sandbox.midtrans.com/snap/v3/redirection/5637df4e-c2b6-4fbc-823c-cbb776f1712b",
            "metadata": {
                "course_id": 1,
                "course_price": 250000,
                "course_name": "Kelas express",
                "course_thumbnail": "www.image.test",
                "level": "advance"
            },
            "created_at": "2022-12-22 14:12:18",
            "updated_at": "2022-12-22 14:12:18"
        },
      ...
    ]
}
```
<br>
<br>

---

### Webhook

### Description
This api webhook for connectifity to Midtrans

### Method
`POST`

### URL
```diff
{URL_API}/api/webhook
```

### Body
```diff
{
  "transaction_time": "2020-01-09 18:27:19",
  "transaction_status": "capture",
  "transaction_id": "57d5293c-e65f-4a29-95e4-5959c3fa335b",
  "status_message": "midtrans payment notification",
  "status_code": "200",
  "signature_key": "930f9829dc8f66120f771e77a809a4a34c0cd0ab5a3f5651e07d5c3f23f6dc9b7aa144d3c5dddf0024dd08c29b8b73c16183857b28499bb8769d1bcdc234af55",
  "payment_type": "credit_card",
  "order_id": "1-abc12",
  "merchant_id": "G141532850",
  "masked_card": "481111-1114",
  "gross_amount": "10000.00",
  "fraud_status": "accept",
  "eci": "05",
  "currency": "IDR",
  "channel_response_message": "Approved",
  "channel_response_code": "00",
  "card_type": "credit",
  "bank": "bni",
  "approval_code": "1578569243927"
}
```

<br>
<br>

---

