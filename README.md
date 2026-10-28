database is in public folder 

admin@gmail.com

12341234

all profile have same password 

make sure to first run

php artisan storage:link

php artisan migrate 

php artisan serve

## Deploying to Vercel

The Vercel configuration builds the Vite assets into `public/build`, copies
public assets into `dist`, and sends non-file requests to Laravel through the
PHP runtime. Files that should not be published as static assets, including
`public/index.php`, are omitted from `dist`.

Set these environment variables in the Vercel project before deploying:

- `APP_KEY` (generate with `php artisan key:generate --show`)
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL` set to the deployed site's URL
- Database connection variables for a persistent managed database
- `SESSION_DRIVER=database` and `CACHE_STORE=database` when using that database
- `LOG_CHANNEL=stderr`

Do not use the repository's SQLite database as a production database on Vercel:
serverless deployments do not provide persistent writable application storage.
Configure the database connection in Vercel, then run `php artisan migrate`
against it. Uploaded files also require persistent object storage (for example,
an S3-compatible disk); Vercel's function filesystem is temporary.

Laravel's temporary framework files are directed to `/tmp` on Vercel. This
allows compiled views and logs to work, but that storage is not persistent.
