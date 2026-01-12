
```
distreaming_backend
├─ .editorconfig
├─ app
│  ├─ Exceptions
│  │  └─ Handler.php
│  ├─ Http
│  │  ├─ Controllers
│  │  │  ├─ Api
│  │  │  │  ├─ Admin
│  │  │  │  │  ├─ CategoryController.php
│  │  │  │  │  └─ MovieController.php
│  │  │  │  ├─ AuthenticationController.php
│  │  │  │  ├─ Public
│  │  │  │  │  ├─ CategoryPublicController.php
│  │  │  │  │  └─ MoviePublicController.php
│  │  │  │  └─ User
│  │  │  │     ├─ RatingController.php
│  │  │  │     └─ WatchHistoryController.php
│  │  │  └─ Controller.php
│  │  ├─ Middleware
│  │  │  └─ EnsureUserIsAdmin.php
│  │  └─ Requests
│  │     ├─ LoginRequest.php
│  │     ├─ RegisterRequest.php
│  │     ├─ StoreCategoryRequest.php
│  │     ├─ StoreMovieRequest.php
│  │     ├─ StoreRatingRequest.php
│  │     ├─ StoreWatchHistoryRequest.php
│  │     ├─ UpdateCategoryRequest.php
│  │     └─ UpdateMovieRequest.php
│  ├─ Models
│  │  ├─ Category.php
│  │  ├─ Movie.php
│  │  ├─ Rating.php
│  │  ├─ User.php
│  │  └─ WatchHistory.php
│  └─ Providers
│     └─ AppServiceProvider.php
├─ artisan
├─ bootstrap
│  ├─ app.php
│  ├─ cache
│  │  ├─ packages.php
│  │  └─ services.php
│  └─ providers.php
├─ composer.json
├─ composer.lock
├─ config
│  ├─ app.php
│  ├─ auth.php
│  ├─ cache.php
│  ├─ cors.php
│  ├─ database.php
│  ├─ filesystems.php
│  ├─ logging.php
│  ├─ mail.php
│  ├─ queue.php
│  ├─ sanctum.php
│  ├─ services.php
│  └─ session.php
├─ database
│  ├─ database.sqlite
│  ├─ factories
│  ├─ migrations
│  │  ├─ 0001_01_01_000000_create_users_table.php
│  │  ├─ 2025_12_09_172428_create_personal_access_tokens_table.php
│  │  ├─ 2025_12_09_194821_create_movies_table.php
│  │  ├─ 2025_12_09_194910_create_categories_table.php
│  │  ├─ 2025_12_09_194921_create_movie_categories_table.php
│  │  ├─ 2025_12_09_194935_create_ratings_table.php
│  │  └─ 2025_12_09_194952_create_watch_histories_table.php
│  └─ seeders
│     ├─ AddMoreMoviesSeeder.php
│     ├─ CreateMoviesAndCategoriesSeeder.php
│     ├─ CreateUsersSeeder.php
│     └─ DatabaseSeeder.php
├─ DiStreaming-requirement.postman_collection.json
├─ docker-compose.yml
├─ dockerfile
├─ laravel.zip
├─ package.json
├─ phpunit.xml
├─ public
│  ├─ .htaccess
│  ├─ favicon.ico
│  ├─ index.php
│  └─ robots.txt
├─ README.md
├─ README1.md
├─ resources
│  ├─ css
│  │  └─ app.css
│  ├─ js
│  │  ├─ app.js
│  │  └─ bootstrap.js
│  └─ views
│     └─ welcome.blade.php
├─ routes
│  ├─ api.php
│  ├─ console.php
│  └─ web.php
├─ storage
│  ├─ app
│  │  ├─ private
│  │  └─ public
│  ├─ framework
│  └─ logs
├─ tests
│  ├─ Feature
│  │  ├─ ExampleTest.php
│  │  └─ FullApiTest.php
│  ├─ TestCase.php
│  └─ Unit
│     └─ ExampleTest.php
├─ tree.md
└─ vite.config.js

```