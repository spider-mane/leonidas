FROM nginx:latest

COPY --from=spidermane/trunk * /trunk

ARG TZ="UTC"
ENV TZ="$TZ"
RUN /trunk/setups/timezone

ARG LANG="en_US.UTF-8"
ENV LANG="$LANG"
RUN /trunk/setups/language

# nginx configurations
RUN /trunk/extras/nginx

# accessories
RUN /trunk/bundles/shell

# cleanup
RUN /trunk/actions/cleanup
