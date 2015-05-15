# weather

Структура проекта
```
├── cron-temp.php
├── index.php
├── model
│   └── Weather.php
└── view
    ├── css
    │   └── style.css
    ├── default.php
    └── js
        ├── chart.js
        └── map.js
```
index.php контроллер приложения
cron-temp.php скрипт, выполняющийся по расписанию, записывает температуру в базу данных
Weather.php содержит класс для обработки данных, чтения и записи в базу данных
default.php страница с картой
chart.js, map.js скрипты для построения графика температуры и отображения карты
