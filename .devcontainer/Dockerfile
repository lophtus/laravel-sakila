FROM mcr.microsoft.com/devcontainers/php:7.4-bullseye
#FROM mcr.microsoft.com/devcontainers/php:1-8.2-bookworm

# Disable Yarn
RUN mv /etc/apt/sources.list.d/yarn.list /etc/apt/sources.list.d/yarn.list-disabled 

# Install MariaDB client
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y mariadb-client \
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*

# Install php-mysql driver
RUN docker-php-ext-install mysqli pdo pdo_mysql

# [Optional] Uncomment this section to install additional OS packages.
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get -y install iputils-ping

# [Optional] Uncomment this line to install global node packages.
# RUN su vscode -c "source /usr/local/share/nvm/nvm.sh && npm install -g <your-package-here>" 2>&1

