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
    -   fixed `could not find driver (SQL: PRAGMA foreign_keys = ON;)` issue by enabling the `pdo_sqlite` extension.
-   Created an account and tested everything that is written down in the "Initial requirements" section. _(cmt: initial review of application)_
    -   During this process, I was able to replicate the permission issue (#2) by replacing the post's slug in my post's edit page URL with other post slug created by another user.
    -   The permission issue #1 doesn't exist - The user can't edit content without logging in.
-   Strategy: While it is an existing project, I decided to maintain the existing style and make as few changes as I can.
-   Issue #1: Stronger passwords. _(br: stronger-passwords-issue-1)_
    -   Found the `PasswordValidationRules` trait with the method `passwordRules` used in password-related validations.
    -   Updated rules, added: `'min:8'`, `'regex:/[^\w]/'`.
    -   Added a new method `passwordCustomMessages` for specifying that the regex error is related to special characters.
    -   Passed custom messages (using unpacking `...` operator) as a second parameter in every action which uses the `passwordRules` method. _(cmt)_
    -   Added the new `test_registration_fails_with_invalid_password` test case. _(cmt)_
    -   Created [PR](https://github.com/MaestroError/area-17-care-exercise/pull/1) and merged.
-   Issue #2: Permissions. _(br: post-permissions-fix)_
    -   Found `PostPolicy` and post's update and store requests, which are used in the posts controller.
    -   Registered `PostPolicy` in `AuthServiceProvider`.
    -   Added try/catch block in PostController's `update` method to authorize the user and return an error message. _(cmt)_
    -   Added the new `test_user_cannot_edit_other_users_post` test case. _(cmt)_
    -   Created [PR](https://github.com/MaestroError/area-17-care-exercise/pull/2) and merged.
-   Issue #3: Performance. _(br: performance-issues)_
    -   Reviewed code and found out:
        -   The `posts` query seems nice and could be optimized in some small details, but it isn't critical.
        -   The `authors` query needs a lot of optimizations and has critical issues.
    -   Optimizing `authors` query used in the sidebar component ("Random authors"):
        -   Moved the take method before the `get` method in the query chain.
        -   The method `with` was replaced with the `withCount` method and added `is_active = true` condition to replicate the logic used in the `authors.blade.php` template
        -   Updated the `authors.blade.php` template to use `posts_count` property
        -   Updated the `@include` directives - passing the authors variable to make obvious, which data is used by the component (increases readability)
        -   Tested, worked - centralized the updated query as a scope to reuse in other controllers _(cmt)_
    -   Considerations about the `posts` query:
        -   Posts query is a pretty good one. I would consider with PM to disable the future publishing (`'published_at', '<=', Carbon::now()`) check in the Post's `published` scope (if it isn't planned), because it is useful with publish scheduling feature and we haven't it in this project.
        -   I would consider adding caching by pages here, but this change adds the "delay" in displaying new posts on the front, so it needs some discussion too.
        -   Also, indexing some columns (author_id, published_at) could be helpful.
    -   Created [PR](https://github.com/MaestroError/area-17-care-exercise/pull/3) and merged.
