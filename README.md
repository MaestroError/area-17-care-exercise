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

-   Any user can sign up and create their own blog (back office)
-   Any visitor can see all posts (front)

### User

#### Specificities

-   Need to register, be logged in login.

#### Model

-   **email**, unique and valid
-   **password**, 8 characters mini and some special characters
-   **username**, unique with no special characters. Slug

### Post

#### Specificities

-   Order by published_at, from now to older (reverse chronological)
-   Need pagination (8 per page).
-   Permalink page `<site>/<username>/<post_unique_slug_from_title>`.
-   Each post view should include a link back to the user's author `<site>/<username>`

#### Model

-   **title**, slug
-   **author_id**, id of the user who has made the post
-   **body**, text
-   **published_at**, datetime (when a post is published)

---

### Process log

-   Updated packages using `composer update`.
-   Checked unit tests by running `php artisan test`. _(cmt: composer update and unit tests checked)_
    -   fixed `could not find driver (SQL: PRAGMA foreign_keys = ON;)` issue by enabling `pdo_sqlite` extension.
-   Created an account and tested everything that is wrote down in "Initial requirements" section. _(cmt: initial review of application)_
    -   During this process, I was able to replicate permission issue (#2) by replacing post's slug in my post's edit page URL with other post slug created by another user.
    -   The permission issue #1 doesn't exist - The user can't edit content without logging in.
-   Strategy: While it is existing project, I decide to maintain existing style and make as few changes as I can.
-   Issue #1: Stronger passwords. _(br: stronger-passwords-issue-1)_
    -   Found the `PasswordValidationRules` trait with method `passwordRules` used in password related validations.
    -   Updated rules, added: `'min:8'`, `'regex:/[^\w]/'`.
    -   Added a new method `passwordCustomMessages` for specifing that the regex error is related to special characters.
    -   Passed custom messages (using unpacking `...` operator) as second parameter in every action which uses the `passwordRules` method. _(cmt)_
    -   Added the new `test_registration_fails_with_invalid_password` test case. _(cmt)_
    -   Created [PR](https://github.com/MaestroError/area-17-care-exercise/pull/1) and merged.
-   Issue #2: Permissions. _(br: post-permissions-fix)_
    -   Found `PostPolicy` and post's update and store requests, which are used in posts controller.
    -   Registered `PostPolicy` in `AuthServiceProvider`.
    -   Added try/catch block in PostController's `update` method to authorize user and return an error message. _(cmt)_
    -   Added the new `test_user_cannot_edit_other_users_post` test case. _(cmt)_
