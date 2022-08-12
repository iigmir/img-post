# ImgPost

A simple app to upload images.

## DB preparation

1. Create a database called `image-app`.
2. Create a table called `images` in the database.
3. Copy `api/db-info.php.example` into a new file, `api/db-info.php`, and set your DB user infos.

## API endpoints

### `api/images-list.php`

* Method: GET

Fetch images list.

Response:

```json
[{
    "avatar": "Image ID",
    "path": "Image path",
    "name": "Image name",
    "description": "Image description"
}]
```

### `api/pictures.php`

Upload an image.

* Method: POST
* Content-type: `multipart/form-data`

Request:

```json
{
    "avatar": "Image file",
    "description": "Image description"
}
```

Response:

```json
{
    "message": "API result.",
    "infos": "Show error messages if error occurred."
}
```
