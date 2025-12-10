app/
├── Models/
│   ├── User.php
│   ├── Movie.php
│   ├── Category.php
│   ├── MovieCategory.php (opsional — bisa pakai pivot)
│   ├── Rating.php
│   └── WatchHistory.php
├── Http/
│   ├── Controllers/Api/
│   │   ├── AuthController.php
│   │   ├── Admin/MovieController.php
│   │   └── Admin/CategoryController.php
│   └── Requests/
│       ├── StoreMovieRequest.php
│       ├── UpdateMovieRequest.php
│       └── StoreCategoryRequest.php
database/
└── migrations/ → semua tabel sesuai ERD