Simple mvc template
============================

Установка
---------
### Ставим через composer

используем команду в корне проекта:

~~~
composer dump-autoload
~~~


Конфиг nginx c php7
-------------------
```nginx
server {
    charset utf-8;
    client_max_body_size 128M;

    listen 80;

    server_name mvc.api;
    root        /home/viktor/projects/simple-mvc/web;
    index       index.php;

    access_log  /var/log/nginx/access.log;
    error_log   /var/log/nginx/error.log;

    location / {
        # Redirect everything that isn't a real file to index.php
        try_files $uri $uri/ /index.php$is_args$args;
    }
    location ~* ^.+\.(ogg|ogv|svg|svgz|eot|otf|woff|mp4|ttf|rss|atom|jpg|jpeg|gif|png|ico|zip|tgz|gz|rar|bz2|doc|xls|exe|ppt|tar|mid|midi|wav|bmp|rtf)$ {
                access_log off;
                log_not_found off;
                expires max; # кеширование статики
        }

    # uncomment to avoid processing of calls to non-existing static files by Yii
    #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
    #    try_files $uri =404;
    #}
    #error_page 404 /404.html;

    # deny accessing php files for the /assets directory
    location ~ \.php$ {
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_pass unix:/run/php/php7.2-fpm.sock;

            try_files $uri =404;
        }


    location ~* /\. {
        deny all;
    }
}
```

Роутер
-------------------

считываем uri из переменной $_SERVER
далее свою работу начинает парсинг, считанного uri
```php
 public function run()
    {
        $this->uri = $_SERVER['REQUEST_URI'];

        $this->parse();
    }
```

Сначала проверяем является ли uri корнем сайта.
Если да, то выбирается дефолтный контроллер и экшен (Site/index)б прописываем namespace и с экшену дописываем слово action (actionIndex)
Иначе:
проверяем есть ли параметры
```php
protected function parse()
    {
        if ($this->uri === '/') {
            $this->controller = $this->setNamespaces($this->defaultController);
            $this->action     = $this->setAction($this->defaultAction);
        } else {
            $this->WorkWithParams();

            if (!$this->routes($this->uri)) {
                $explode = explode('/', $this->uri);

                if (count($explode) == 2){
                    $this->controller = $this->setNamespaces($explode[1]);
                    $this->action     = $this->setAction($this->defaultAction);
                }else{
                    $this->controller = $this->setNamespaces($explode[1]);
                    $this->action     = $this->setAction($explode[2]);
                }
            }
        }

        $this->runAction();
    }
```