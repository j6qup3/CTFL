# CTFL
CTFL -- CRUD Template For Laravel

Usage:
1. Model: 
File app/Models/CRUDTable.php, no need to modify, just move it into your models folder.
PS. Depend on MySQL DB, this template only works on the table which has primary-key field (also auto-increment is better).

2. View:
File resources/views/crud/crud.blade.php, just move it into your views folder and add @include('crud.crud') in blade file.
File resources/views/crud/update.blade.php, also, just move it into your resources/views folder and add @include('crud.update') in blade file.
PS. Depend on Bootstrap and jQuery, you can modify the href of CSS link and the src of script of JS in the begin of file, or they won't work without Internet connection.
PS2. You can modify the the togglelist of table.

3. Controller:
File app/Http/Controllers/CRUDController.php, just move it into your app/Http/Controllers folder.
PS. You can modify some settings such as "those table that are abandoned to access in CTFL" (none as default), "decide whether fields will show in CTFL" (true as default), "names of each field that will be show in CTFL" (origin field name as default), "decide whether field can be modify when update in CTFL" (false as default)
PS2. Throwing NotFoundHttpException (404) to handle exceptions and errors.

4. Route:
File app/Http/route_crud.php, just move it into app/Http folder and add include('route_crud.php') in your app/Http/route.php (or copy the codes in route_crud.php then paste on app/Http/route.php)
PS. You should implement a auth middleware (modifying function handle in app/Http/Middleware/Authenticate.php is better).
PS2. As default, { HOST }/crud/{name of table} can enter the CTFL with that table. By the way, you can modify it too.

CTFL is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

At last, forgive my poor english ability.

中文待補
用法：
