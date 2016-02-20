# CTFL - CRUD Template For Laravel
## Extend Version (Controll can be easily to extend, but unconvenience for developer)

### Usage:


- Model: 

    - File `app/Models/CRUDTable.php`, no need to modify, just move it into your `models` folder.

    - Depend on MySQL DB, this template only works on the table which has primary-key field (also auto-increment is better).


- View:

    - File `resources/views/crud/crud.blade.php`, just move it into your views folder and add `@include('crud.crud')` in blade file.

    - File `resources/views/crud/update.blade.php`, also, just move it into your `resources/views` folder and add `@include('crud.update')` in blade file.

    - Depend on Bootstrap and jQuery, you can modify the href of CSS link and the src of JS script in the begin of file, or they won't work without Internet connection.

    - You can modify the the togglelist of table menu.


- Controller:

    - File `app/Http/Controllers/CRUDController.php`, just move it into your `app/Http/Controllers` folder.

    - You can modify some settings such as "those table that are abandoned to access in CTFL" (none as default), "decide whether fields will show in CTFL" (true as default), "names of each field that will be show in CTFL" (origin field name as default), "decide whether field can be modify when update in CTFL" (false as default)

    - Throwing NotFoundHttpException (404) to handle exceptions and errors.

- Route:

    - File `app/Http/route_crud.php`, just move it into `app/Http` folder and add `include('route_crud.php')` in your `app/Http/route.php` (or copy the codes in `route_crud.php` then paste on `app/Http/route.php`)

    - You should implement a auth middleware (modifying function handle in `app/Http/Middleware/Authenticate.php` is better).

    - As default, `{ HOST }/crud/{name of table}` can enter the CTFL with that table. By the way, you can modify it too. However, you can only redirect it to `{ HOST }/crud/{name of table}` if you only modify `route.php`. You can add a function in `CRUDController.php` which calls `function view()` and let customized route link to that function.
    
    - This version is Extend Version which Controller can't be easily extended. But is unconvenient for developer because there are more than one controllers and many routes. You can try the Fixed Version if you want conventient.

At last, forgive my poor english ability.


#### CTFL is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

# CTFL - 為 Laravel 設計的 CRUD 模板
## Extend 版本 (Controller 可以被繼承，但對開發者來說較不方便的版本)

### 用法：


- Model: 

    - 檔案 `app/Models/CRUDTable.php`，不用去更改它，只要移進你的 `models` 資料夾就行了。

    - 本模板基於 MySQL 資料庫，只會對有私有鍵欄位的資料表起作用 (該欄位如果同時是 auto-increment 就更好了)。


- View:

    - 檔案 `resources/views/crud/crud.blade.php`，只要移進你的 `resources/views` 資料夾並在 blade 檔加上 `@include('crud.crud')` 就行了。

    - 檔案 `resources/views/crud/update.blade.php`，同樣也只要移進你的 `resources/views` 資料夾並在 blade 檔加上 `@include('crud.update')` 就行了。

    - 本模板基於 Bootstrap 和 jQuery，你可以修改檔案開頭的 CSS link 的 href 和 JS script 的  src，否則它們在沒網路的情況下不會呈現正常效果。

    - 你可以修改資料表目錄的 togglelist。


- Controller:

    - 檔案 `app/Http/Controllers/CRUDController.php`，只要移進你的 `app/Http/Controllers` 資料夾。

    - 你可以修改一些設置，像是 "某欄位是否顯示"(fieldshows，預設 true)、"某欄位名稱"(fieldnames，預設為資料表名)、"某欄位是不是被固定無法更新"(fieldfixeds，預設 false)

    - error 和 exception 處理部份目前一律以拋出 NotFoundHttpException (404) 處理。

- Route:

    - 檔案 `app/Http/route_crud.php`，只要移進你的 `app/Http` 資料夾然後在 `app/Http/route.php` 加上 `include('route_crud.php')` (或是複製 `route_crud.php` 內的程式碼貼到 `app/Http/route.php` 裡面)

    - 你應該實作一個驗證權限的 middleware (最好更改 `app/Http/Middleware/Authenticate.php` 中的函式 handle)。

    - 預設上，網址 `{ HOST }/crud/{name of table}` 可以進入關於該資料表的 CTFL 介面。順帶一提，你也可以更改這個設定。但是，如果只動 `route.php` 的話，你只能將網址重定向到 `{ HOST }/crud/{name of table}`。你也可以在 `CRUDController.php` 中增加一個呼叫 `function view()` 的函式，然後再將自定義的 route 連結到那個函式。
    
    - 這個版本是 Extend Version，Controller 可以被繼承 (自由度較高)，但是對開發者來說比較不方便，因為它用多個 Controller 和較多的 route。若你想要方便，可以試試 Fixed Version。


####CTFL 是開源軟體，授權於 [MIT license](http://opensource.org/licenses/MIT)
