# URL

## WEB

- top (未ログイン)
    - GET /

- タイムライン (ログイン後のホーム)
    - GET /timeline

- ユーザーページ
    - GET /users/{ユーザーID}

- ユーザー一覧
    - GET /users?検索条件

- 新規投稿
    - GET /photos/create
    - POST /photos

- フォロー
    - POST /follow/{user_id}.json
    - DELETE /follow/{user_id}.json

- リアクション
    - POST /photos/{photo_id}/reaction.json
    - DELETE /photos/{photo_id}/reaction.json


## API

- フォロー
    - POST /api/follow/{user_id}.json
    - DELETE /api/follow/{user_id}.json

- リアクション
    - POST /api/photos/{photo_id}/reaction.json
    - DELETE /api/photos/{photo_id}/reaction.json

