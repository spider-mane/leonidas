FROM nginx:latest

COPY --from=spidermane/trunk * /trunk

RUN /trunk/extras/nginx

RUN /trunk/actions/cleanup
