FROM ubuntu:22.04 as app

LABEL maintainer="Chris Williams"

ENV DEBIAN_FRONTEND=noninteractive

ENV APP=/var/www/html
WORKDIR $APP

ARG TZ=UTC
ENV TZ="${TZ}"
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install basic requirements
RUN apt-get update \
  && apt-get install -y gnupg gosu curl wget ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python3 dnsutils

# Install PHP
ARG PHP_VERSION=8.0
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY docker/php/bin/php-get /usr/local/bin
RUN curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c' \
  | gpg --dearmor \
  | tee /usr/share/keyrings/ppa_ondrej_php.gpg > /dev/null \
  && echo "deb [signed-by=/usr/share/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" \
  > /etc/apt/sources.list.d/ppa_ondrej_php.list \
  && apt-get update \
  && chmod +x /usr/local/bin/php-get \
  && php-get install $PHP_VERSION fpm cli dev pgsql sqlite3 gd curl imap mysql mbstring xml zip bcmath soap intl readline ldap msgpack \
  igbinary redis swoole memcached pcov xdebug imagick \
  && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

# Install Node
ARG NODE_VERSION=18
RUN curl -sLS https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
  && apt-get install -y nodejs \
  && npm install -g npm \
  && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor | tee /usr/share/keyrings/yarn.gpg >/dev/null \
  && echo "deb [signed-by=/usr/share/keyrings/yarn.gpg] https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
  && apt-get update \
  && apt-get install -y yarn

# Install database clients
ARG POSTGRES_VERSION=14
RUN apt-get install -y mysql-client \
  && curl -sS https://www.postgresql.org/media/keys/ACCC4CF8.asc | gpg --dearmor | tee /usr/share/keyrings/pgdg.gpg >/dev/null \
  && echo "deb [signed-by=/usr/share/keyrings/pgdg.gpg] http://apt.postgresql.org/pub/repos/apt jammy-pgdg main" > /etc/apt/sources.list.d/pgdg.list \
  && apt-get update \
  && apt-get install -y postgresql-client-$POSTGRES_VERSION

# Cleanup
RUN apt-get -y autoremove \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php$PHP_VERSION

# Copy php configuration
COPY --from=php:fpm /usr/local/etc/php-fpm.d/docker.conf /etc/php/$PHP_VERSION/fpm/pool.d/aa-docker.conf
COPY --from=php:fpm /usr/local/etc/php-fpm.d/zz-docker.conf /etc/php/$PHP_VERSION/fpm/pool.d/zz-docker.conf
COPY docker/php/etc/fpm/ /etc/php/$PHP_VERSION/fpm/
COPY docker/php/etc/cli/ /etc/php/$PHP_VERSION/cli/

# Copy supervisor configuration
COPY docker/php/etc/supervisor/ /etc/supervisor/

# Prepare entrypoint
COPY docker/php/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT [ "docker-entrypoint.sh" ]

EXPOSE 9000

### Build with interactive features ###
FROM app as app-interactive

RUN apt-get update && apt-get install -y apt-utils

# Maybe unminimize
ARG UNMINIMIZE
RUN if [ "$UNMINIMIZE" = true ]; then yes | unminimize; fi

# Install basic requirements
RUN apt-get install -y locales pass ripgrep

# Install Zsh
RUN apt-get install -y zsh \
  && bash -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" \
  && ZSH_CUSTOM=$HOME/.oh-my-zsh/custom \
  && git clone --depth=1 https://github.com/romkatv/powerlevel10k.git $ZSH_CUSTOM/themes/powerlevel10k \
  && git clone --depth=1 https://github.com/zdharma-continuum/fast-syntax-highlighting.git $ZSH_CUSTOM/plugins/fast-syntax-highlighting

# Install Bat
RUN BAT_VERSION=0.22.1 \
  && curl --output-dir /tmp -LO https://github.com/sharkdp/bat/releases/download/v$BAT_VERSION/bat_${BAT_VERSION}_amd64.deb \
  && dpkg -i /tmp/bat_${BAT_VERSION}_amd64.deb \
  && git clone --depth=1 https://github.com/eth-p/bat-extras.git /opt/bat-extras \
  && /opt/bat-extras/build.sh --install --minify=none

# Update and enhance Git
RUN curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0xe1dd270288b4e6030699e45fa1715d88e1df1f24' \
  | gpg --dearmor \
  | tee /usr/share/keyrings/git-core.gpg > /dev/null \
  && echo "deb [signed-by=/usr/share/keyrings/git-core.gpg] https://ppa.launchpadcontent.net/git-core/ppa/ubuntu jammy main" \
  > /etc/apt/sources.list.d/git-core.list \
  && apt-get update \
  && apt-get install -y git git-extras \
  && GCM_VERSION=2.0.886 \
  && curl --output-dir /tmp -LO https://github.com/GitCredentialManager/git-credential-manager/releases/download/v$GCM_VERSION/gcm-linux_amd64.$GCM_VERSION.deb \
  && dpkg -i /tmp/gcm-linux_amd64.$GCM_VERSION.deb \
  && git-credential-manager configure \
  && DELTA_VERSION=0.15.1 \
  && curl --output-dir /tmp -LO https://github.com/dandavison/delta/releases/download/$DELTA_VERSION/git-delta_${DELTA_VERSION}_amd64.deb \
  && dpkg -i /tmp/git-delta_${DELTA_VERSION}_amd64.deb

# Install Github CLI
RUN curl -sSL https://cli.github.com/packages/githubcli-archive-keyring.gpg \
  | gpg --dearmor \
  | tee /usr/share/keyrings/github-cli.gpg > /dev/null \
  && echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/github-cli.gpg] https://cli.github.com/packages stable main" \
  > /etc/apt/sources.list.d/github-cli.list \
  && apt update \
  && apt install gh -y

# Install global Composer packages
RUN composer global config --no-plugins allow-plugins.franzl/studio true \
  && composer global require franzl/studio

# Install global Node packages
RUN npm i -g npm-check-updates

# Configure Git
ARG GIT_DEFAULT_BRANCH=master
ARG GIT_USER
ARG GIT_EMAIL
RUN git config --global user.name "$GIT_USER" \
  && git config --global user.email "$GIT_EMAIL" \
  && git config --global credential.credentialStore gpg \
  && git config --global core.pager delta \
  && git config --global interactive.diffFilter "delta --color-only" \
  && git config --global merge.conflictstyle diff3 \
  && git config --global diff.colorMoved default \
  && git config --global git-extras.default-branch "$GIT_DEFAULT_BRANCH" \
  && git config --global delta.navigate true \
  && git config --global delta.features "side-by-side line-numbers decorations"

# Set up credential store
RUN gpg --quick-gen-key --no-tty --pinentry-mode loopback --passphrase '' "$GIT_USER" rsa4096 default never \
  && pass init "$GIT_USER"

# Update locale
ARG LANG=en_US.UTF-8
ENV LANG="${LANG}"
RUN locale-gen "$LANG"

# Shell config files
COPY docker/php/~/ /root/

# Cleanup
RUN apt-get -y autoremove \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
