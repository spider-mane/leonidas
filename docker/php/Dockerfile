FROM ubuntu:22.04 as app

LABEL maintainer="Chris Williams"

COPY --from=spidermane/trunk * /trunk

ENV DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV WP_CLI_ALLOW_ROOT=1
ENV APP=/var/www/html

WORKDIR "$APP"

ARG TZ="UTC"
ENV TZ="$TZ"
RUN /trunk/setups/timezone

ARG LANG="en_US.UTF-8"
ENV LANG="$LANG"
RUN /trunk/setups/language

RUN /trunk/actions/install mysql-client

ARG NODE_VERSION=18
RUN /trunk/provisions/node --version "$NODE_VERSION"

ARG PHP_VERSION="8.0"
RUN /trunk/provisions/php --version "$PHP_VERSION" --bundle web --stack imagick --dev true

RUN /trunk/setups/entrypoint web
RUN /trunk/provisions/supervisor --php-version "$PHP_VERSION"
ENTRYPOINT [ "docker-entrypoint" ]

EXPOSE 9000

RUN /trunk/actions/cleanup

### Build with interactive features ###
FROM app as app-interactive

COPY --from=spidermane/trunk * /trunk

ARG UNMINIMIZE=false
RUN /trunk/actions/unminimize "$UNMINIMIZE"

ARG LOCAL_REPOSITORY=/studio
RUN /trunk/provisions/studio --path "$LOCAL_REPOSITORY"

ARG GIT_USER
ARG GIT_EMAIL
ARG GIT_DEFAULT_BRANCH=master
ARG GIT_INSTALL_GCM=false
RUN /trunk/provisions/git --user "$GIT_USER" --email "$GIT_EMAIL" --default-branch "$GIT_DEFAULT_BRANCH" --install-gcm "$GIT_INSTALL_GCM"

RUN /trunk/bundles/shell
RUN /trunk/provisions/github

RUN npm install -g npm-check-updates

RUN /trunk/setups/user
RUN /trunk/actions/cleanup
