FROM php:8.2-cli

WORKDIR /app

COPY bot.php /app/index.php

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "/app"]
