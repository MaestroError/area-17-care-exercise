# A17 Blog
## Requirements

You need to have PHP, NodeJS and MySQL to run this project. We recommend
using [Laravel Valet](https://laravel.com/docs/8.x/valet) in local development.

### Installation

```console
$ cd exercise-repo
$ composer install
$ cp .env.example .env
$ php artisan key:generate
```

Note: Do not forget to start your database!

Make sure to update your `.env` file:

```shell
DB_DATABASE={your-database}
APP_URL={your-url}
```

Once you're done, you can seed the database with data:

```console
$ php artisan migrate --seed
```

### Tests

You can run application tests with Artisan:

```console
$ php artisan test
```

## Specs
### Important points
- Any user can sign up and create their own blog (back office)
- Any visitor can see all posts (front)

### User
#### Specificities
- Need to register, be logged in login.

#### Model
- **email**, unique and valid
- **password**, 8 characters mini and some special characters
- **username**, unique with no special characters. Slug

### Post
#### Specificities
- Order by published_at, from now to older (reverse chronological)
- Need pagination (8 per page).
- Permalink page `<site>/<username>/<post_unique_slug_from_title>`.
- Each post view should include a link back to the user's author `<site>/<username>`

#### Model
- **title**, slug
- **author_id**, id of the user who has made the post
- **body**, text
- **published_at**, datetime (when a post is published)