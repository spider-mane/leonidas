FROM ubuntu:22.04 as app

LABEL maintainer="Chris Williams"

EXPOSE 9000

COPY --from=spidermane/trunk * /trunk

ENV DEBIAN_FRONTEND=noninteractive
ENV APP=/var/www/html
ENV TRUNK_USER=leonidas

VOLUME [ "$APP" ]
WORKDIR "$APP"

ARG TZ="UTC"
ENV TZ="$TZ"
RUN /trunk/setups/timezone

ARG LANG="en_US.UTF-8"
ENV LANG="$LANG"
RUN /trunk/setups/language

RUN /trunk/setups/user

RUN /trunk/actions/install mysql-client

ARG NODE_VERSION=18
RUN /trunk/provisions/node --version "$NODE_VERSION"

ARG PHP_VERSION="8.1"
RUN /trunk/provisions/php --version "$PHP_VERSION" --bundle web --stack imagick --dev true

RUN /trunk/setups/entrypoint web
RUN /trunk/provisions/supervisor --php-version "$PHP_VERSION"
ENTRYPOINT [ "docker-entrypoint" ]

RUN /trunk/setups/healthcheck
HEALTHCHECK CMD [ "docker-healthcheck" ] --interval=1s --timeout=1s

RUN /trunk/actions/cleanup

### Build with interactive features ###
FROM app as app-interactive

COPY --from=spidermane/trunk * /trunk

ARG UNMINIMIZE=false
RUN /trunk/actions/unminimize "$UNMINIMIZE"

ARG LOCAL_REPOSITORY=/packages
VOLUME [ "$LOCAL_REPOSITORY" ]
RUN /trunk/provisions/pathagist --path "$LOCAL_REPOSITORY"

ARG GIT_USER
ARG GIT_EMAIL
ARG GIT_DEFAULT_BRANCH=master
ARG GIT_INSTALL_GCM=false
RUN /trunk/provisions/git --user "$GIT_USER" --email "$GIT_EMAIL" --default-branch "$GIT_DEFAULT_BRANCH" --install-gcm "$GIT_INSTALL_GCM"
RUN /trunk/provisions/github

ENV ZSH=/usr/lib/omz
RUN /trunk/bundles/shell

RUN npm install -g npm-check-updates

HEALTHCHECK CMD [ "docker-healthcheck" ] --interval=1s --timeout=1s --start-period=3s

RUN /trunk/actions/cleanup
