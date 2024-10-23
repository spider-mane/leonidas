FROM ubuntu:22.04 AS app

LABEL maintainer="Chris Williams"

EXPOSE 9000

COPY --from=spidermane/trunk * /trunk

ENV DEBIAN_FRONTEND=noninteractive

ENV APP=/var/www/html
WORKDIR "$APP"

ENV TRUNK_USER=leonidas
RUN /trunk/setups/user

ARG PHP_VERSION="8.2"
RUN /trunk/provisions/php --version "$PHP_VERSION" --bundle cms --dev true

RUN /trunk/setups/entrypoint web
RUN /trunk/provisions/supervisor --php-version "$PHP_VERSION"
ENTRYPOINT [ "docker-entrypoint" ]

RUN /trunk/setups/healthcheck
HEALTHCHECK --interval=1s --timeout=1s \
  CMD [ "docker-healthcheck" ]

RUN /trunk/actions/cleanup

### INTERACTIVE ###
FROM app AS app-shell

COPY --from=spidermane/trunk * /trunk

ENV ZSH=/usr/lib/omz
RUN /trunk/bundles/shell

RUN /trunk/actions/cleanup

### DEVELOPMENT ###
FROM app-shell AS app-dev

COPY --from=spidermane/trunk * /trunk

ARG NODE_VERSION="20"
RUN /trunk/provisions/node --version "$NODE_VERSION"

RUN npm install -g bun

RUN /trunk/actions/cleanup

### LOCAL ###
FROM app-dev AS app-local

COPY --from=spidermane/trunk * /trunk

ARG TZ="UTC"
ENV TZ="$TZ"
RUN /trunk/setups/timezone

ARG LANG="en_US.UTF-8"
ENV LANG="$LANG"
RUN /trunk/setups/language

ENV PHP_REPOSITORY=/packages
RUN /trunk/provisions/pathagist --path "$PHP_REPOSITORY"

RUN /trunk/actions/cleanup

### WORKSPACE ###
FROM app-local AS app-workspace

COPY --from=spidermane/trunk * /trunk

ARG UNMINIMIZE=false
RUN /trunk/actions/unminimize "$UNMINIMIZE"

ARG GIT_USER
ARG GIT_EMAIL
ARG GIT_DEFAULT_BRANCH=master
ARG GIT_INSTALL_GCM=false
RUN /trunk/provisions/git --user "$GIT_USER" --email "$GIT_EMAIL" --default-branch "$GIT_DEFAULT_BRANCH" --install-gcm "$GIT_INSTALL_GCM"
RUN /trunk/provisions/github

RUN npm install -g npm-check-updates

HEALTHCHECK --interval=1s --timeout=1s --start-period=3s \
  CMD [ "docker-healthcheck" ]

RUN /trunk/actions/cleanup
