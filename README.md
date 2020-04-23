# format-date
一个简易的时间/日期转换工具，可以将`Y-m-d H:i:s`形式的时间日期转换为`刚刚`、`1 分钟前`、`60 分钟前`、`今天 11:58`、`昨天 12:00`等形式，常用于列表时间显示。

## Installing
```shell
$ composer require newteng/format-date -vvv
```

## Usage
### Common
```php
<?php

require __DIR__ . '/vendor/autoload.php';
$format = new \Newteng\FormatDate\FormatDateToStr();
echo $format->transform(date('Y-m-d H:i:s', time() - 1500)); // 25 分钟前

...

```

### Laravel 
```php
<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Newteng\FormatDate\FormatDateToStr;

class IndexController extends Controller
{
    public function index(FormatDateToStr $formatDateToStr)
    {
        $dateStr = date('Y-m-d H:i:s', time() - 1500);
        // return $formatDateToStr->transform($dateStr);
        
        // or
        
        return app('format_date_to_str')->transform(Carbon::now()->subMinute(15)); // 15 分钟前
    }

}

```

## License

MIT