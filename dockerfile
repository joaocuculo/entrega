# Use uma imagem PHP com Apache
FROM php:8.1-apache

# Copie os arquivos do seu projeto para o diretório padrão do Apache
COPY . /var/www/html/

# Instala extensões PHP necessárias (ajuste conforme necessário)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Exponha a porta 80 para acessar o Apache
EXPOSE 8080
