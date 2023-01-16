FROM rabbitmq:3.11.6-management
COPY ./plugins/rabbitmq_delayed_message_exchange.ez /opt/rabbitmq/plugins/rabbitmq_delayed_message_exchange.ez
RUN rabbitmq-plugins enable --offline rabbitmq_delayed_message_exchange